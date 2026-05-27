<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des utilisateurs de la plateforme.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (! Schema::hasColumn('users', 'phone')) {
                    $table->string('phone')->nullable()->unique()->after('email');
                }

                if (! Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['client', 'admin'])->default('client')->index()->after('password');
                }

                if (! Schema::hasColumn('users', 'is_blocked')) {
                    $table->boolean('is_blocked')->default(false)->index()->after('role');
                }

                if (! Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken()->after('is_blocked');
                }

                if (! Schema::hasColumn('users', 'created_at') && ! Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['client', 'admin'])->default('client')->index();
            $table->boolean('is_blocked')->default(false)->index();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Supprime la table des utilisateurs.
     */
    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            foreach (['phone', 'role', 'is_blocked'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
