<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des factures PDF.
     */
    public function up(): void
    {
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                if (! Schema::hasColumn('invoices', 'order_id')) {
                    $table->foreignId('order_id')->nullable()->unique()->after('id')->constrained()->cascadeOnDelete();
                }

                if (! Schema::hasColumn('invoices', 'invoice_number')) {
                    $table->string('invoice_number')->nullable()->unique()->after('order_id');
                }

                if (! Schema::hasColumn('invoices', 'pdf_path')) {
                    $table->string('pdf_path')->nullable()->after('invoice_number');
                }

                if (! Schema::hasColumn('invoices', 'created_at') && ! Schema::hasColumn('invoices', 'updated_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Supprime la table des factures.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
