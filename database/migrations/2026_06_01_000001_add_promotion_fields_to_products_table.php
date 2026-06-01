<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajoute les champs de promotion aux produits.
     */
    public function up(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'is_promoted')) {
                $table->boolean('is_promoted')->default(false)->index()->after('price');
            }

            if (! Schema::hasColumn('products', 'promotion_price')) {
                $table->unsignedInteger('promotion_price')->nullable()->after('is_promoted');
            }

            if (! Schema::hasColumn('products', 'promotion_ends_at')) {
                $table->dateTime('promotion_ends_at')->nullable()->index()->after('promotion_price');
            }
        });
    }

    /**
     * Retire les champs de promotion.
     */
    public function down(): void
    {
        if (! Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            foreach (['promotion_ends_at', 'promotion_price', 'is_promoted'] as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
