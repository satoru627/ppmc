<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des demandes de support client.
     */
    public function up(): void
    {
        if (Schema::hasTable('support_tickets')) {
            Schema::table('support_tickets', function (Blueprint $table) {
                if (! Schema::hasColumn('support_tickets', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
                }

                if (! Schema::hasColumn('support_tickets', 'subject')) {
                    $table->string('subject')->after('user_id');
                }

                if (! Schema::hasColumn('support_tickets', 'message')) {
                    $table->text('message')->after('subject');
                }

                if (! Schema::hasColumn('support_tickets', 'status')) {
                    $table->enum('status', ['open', 'in_progress', 'closed'])->default('open')->index()->after('message');
                }

                if (! Schema::hasColumn('support_tickets', 'created_at') && ! Schema::hasColumn('support_tickets', 'updated_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open')->index();
            $table->timestamps();
        });
    }

    /**
     * Supprime la table des demandes de support.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
