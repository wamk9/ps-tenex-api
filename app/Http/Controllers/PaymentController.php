<?php

namespace App\Http\Controllers;

use App\Models\PaymentBooklet;
use App\Models\PaymentSlip;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function store ()
    {
        try
        {
            $validator = Validator::make(request()->all(), [
                'valor_total' => 'required|numeric',
                'qtd_parcelas' => 'required|numeric',
                'data_primeiro_vencimento' => 'required|date_format:Y-m-d',
                'periodicidade' => 'required|string|in:mensal,semanal',
                'valor_entrada' => 'sometimes|numeric'
            ]);

            if($validator->fails())
            {
                throw new ValidationException($validator);
            }

            DB::beginTransaction();

            $paymentBooklet = new PaymentBooklet();
            $paymentBooklet->valor_total = request()->valor_total;
            $paymentBooklet->qtd_parcelas = request()->qtd_parcelas;
            $paymentBooklet->data_primeiro_vencimento = Carbon::createFromFormat('Y-m-d', request()->data_primeiro_vencimento)->format('Y-m-d');
            $paymentBooklet->periodicidade = request()->periodicidade;
            $paymentBooklet->valor_entrada = request()->has("valor_entrada") ? request()->valor_entrada : 0;
            $paymentBooklet->save();

            $paymentSlipValue = ($paymentBooklet->valor_total - $paymentBooklet->valor_entrada) / ($paymentBooklet->valor_entrada == 0 ? $paymentBooklet->qtd_parcelas : ($paymentBooklet->qtd_parcelas - 1));

            for ($i = 0; $i < $paymentBooklet->qtd_parcelas; $i++)
            {
                $paymentSlip = new PaymentSlip();
                $paymentDate = null;

                if ($paymentBooklet->valor_entrada == 0 || ($paymentBooklet->valor_entrada > 0 && $i > 0))
                {
                    $paymentDate = Carbon::parse($paymentBooklet->data_primeiro_vencimento);
                    $paymentDate = ($paymentBooklet->periodicidade == "semanal" ?
                        $paymentDate->addWeeks($paymentBooklet->valor_entrada > 0 ? ($i - 1)  :$i) :
                        $paymentDate->addMonths($paymentBooklet->valor_entrada > 0 ? ($i - 1) : $i));
                }

                $paymentSlip->data_vencimento = $paymentDate;
                $paymentSlip->valor = ($paymentBooklet->valor_entrada > 0.0 && $i == 0 ? $paymentBooklet->valor_entrada : $paymentSlipValue);
                $paymentSlip->numero = ($i + 1);
                $paymentSlip->entrada = ($paymentBooklet->valor_entrada > 0.0 && $i == 0);
                $paymentSlip->paymentbooklet_id = $paymentBooklet->id;

                $paymentSlip->save();
            }

            DB::commit();

            $paymentBooklet->parcelas;

            return response()->json($paymentBooklet, 200);
        }
        catch (ValidationException $ex)
        {
            return response()->json(['error' => $ex->errors()], 400);

        }
        catch (Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function show ()
    {
        try
        {
            $validator = Validator::make(request()->route()->parameters(), [
                'id' => 'required|numeric|exists:payment_booklets,id'
            ]);

            if($validator->fails())
            {
                throw new ValidationException($validator);
            }

            $paymentBooklet = PaymentBooklet::find(request()->route()->id);
            $paymentBooklet->parcelas;

            return response()->json($paymentBooklet, 200);
        }
        catch (ValidationException $ex)
        {
            return response()->json(['error' => $ex->errors()], 400);

        }
        catch (Exception $ex)
        {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
