<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentSlip extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "data_vencimento",
        "valor",
        "numero",
        "entrada",
        "paymentbooklet_id"
    ];

    protected $casts = [
        "data_vencimento" => "date:Y-m-d",
        "valor" => "float",
        "numero" => "int",
        "entrada" => "boolean",
    ];

    protected $hidden = [
        "id",
        "paymentbooklet_id"
    ];

    /**
     * Get the paymentBooklet associated with the PaymentSlip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentBooklet(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'paymentbooklet_id');
    }
}
