<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentBooklet extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "valor_total",
        "qtd_parcelas",
        "data_primeiro_vencimento",
        "periodicidade",
        "valor_entrada"
    ];

    protected $casts = [
        "valor_total" => "float",
        "qtd_parcelas" => "int",
        "data_primeiro_vencimento" => "date:Y-m-d",
        "periodicidade" => "string",
        "valor_entrada" => "float"
    ];

    protected $dateFormat = 'Y-m-d';

    protected $hidden = [
        "id"
    ];

    /**
     * Get all of the paymentSlips for the PaymentBooklet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parcelas(): HasMany
    {
        return $this->hasMany(PaymentSlip::class, 'paymentbooklet_id', 'id');
    }
}
