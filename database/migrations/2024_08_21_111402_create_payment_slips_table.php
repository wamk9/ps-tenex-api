<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('payment_slips', function (Blueprint $table) {
            $table->id();
            $table->date("data_vencimento")->default(null)->nullable();
            $table->float("valor");
            $table->integer("numero", false, true);
            $table->boolean("entrada")->default(false);
            $table->integer("paymentbooklet_id", false, true);

            $table->foreign("paymentbooklet_id")->references('id')->on("payment_booklets");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_slips');
    }
};
