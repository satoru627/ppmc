<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Renomme l'ancienne colonne CinetPay en reference de paiement generique.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'cinetpay_transaction_id') && ! Schema::hasColumn('orders', 'payment_reference')) {
                $table->renameColumn('cinetpay_transaction_id', 'payment_reference');
            }
        });
    }

    /**
     * Retour arriere vers l'ancien nom.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_reference') && ! Schema::hasColumn('orders', 'cinetpay_transaction_id')) {
                $table->renameColumn('payment_reference', 'cinetpay_transaction_id');
            }
        });
    }
};
