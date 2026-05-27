<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des commandes clients.
     */
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
                }

                if (! Schema::hasColumn('orders', 'product_id')) {
                    $table->foreignId('product_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
                }

                if (! Schema::hasColumn('orders', 'amount')) {
                    $table->unsignedInteger('amount')->default(0)->after('product_id');
                }

                if (! Schema::hasColumn('orders', 'status')) {
                    $table->enum('status', ['pending', 'paid', 'failed', 'canceled'])->default('pending')->index()->after('amount');
                }

                if (! Schema::hasColumn('orders', 'payment_reference')) {
                    $table->string('payment_reference')->nullable()->unique()->after('status');
                }

                if (! Schema::hasColumn('orders', 'paid_at')) {
                    $table->timestamp('paid_at')->nullable()->after('payment_reference');
                }

                if (! Schema::hasColumn('orders', 'created_at') && ! Schema::hasColumn('orders', 'updated_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('amount');
            $table->enum('status', ['pending', 'paid', 'failed', 'canceled'])->default('pending')->index();
            $table->string('payment_reference')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Supprime la table des commandes.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
