<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des contacts laisses avant redirection vers Chariow.
     */
    public function up(): void
    {
        if (Schema::hasTable('purchase_leads')) {
            return;
        }

        Schema::create('purchase_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_title');
            $table->unsignedInteger('product_price')->default(0);
            $table->string('name', 120)->nullable();
            $table->string('email', 190)->nullable()->index();
            $table->string('status', 40)->default('pending_payment')->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
        });
    }

    /**
     * Supprime la table des contacts d'achat.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_leads');
    }
};
