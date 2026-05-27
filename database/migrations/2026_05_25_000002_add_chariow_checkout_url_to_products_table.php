<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute le lien de paiement Chariow optionnel.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'chariow_checkout_url')) {
                $table->string('chariow_checkout_url', 2048)->nullable()->after('price');
            }
        });
    }

    /**
     * Retire le lien de paiement Chariow.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'chariow_checkout_url')) {
                $table->dropColumn('chariow_checkout_url');
            }
        });
    }
};
