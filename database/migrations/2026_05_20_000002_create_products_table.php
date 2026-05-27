<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cree la table des formations et services vendus.
     */
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'title')) {
                    $table->string('title')->after('id');
                }

                if (! Schema::hasColumn('products', 'slug')) {
                    $table->string('slug')->nullable()->unique()->after('title');
                }

                if (! Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('slug');
                }

                if (! Schema::hasColumn('products', 'type')) {
                    $table->enum('type', ['formation', 'service'])->default('formation')->index()->after('description');
                }

                if (! Schema::hasColumn('products', 'price')) {
                    $table->unsignedInteger('price')->default(0)->after('type');
                }

                if (! Schema::hasColumn('products', 'file_path')) {
                    $table->string('file_path')->nullable()->after('price');
                }

                if (! Schema::hasColumn('products', 'image')) {
                    $table->string('image')->nullable()->after('file_path');
                }

                if (! Schema::hasColumn('products', 'is_active')) {
                    $table->boolean('is_active')->default(true)->index()->after('image');
                }

                if (! Schema::hasColumn('products', 'created_at') && ! Schema::hasColumn('products', 'updated_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['formation', 'service'])->index();
            $table->unsignedInteger('price');
            $table->string('file_path')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Supprime la table des formations et services.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
