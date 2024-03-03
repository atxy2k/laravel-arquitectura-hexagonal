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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 140);
            $table->string('slug', 140);
            $table->foreignId('marca_id')->nullable()->references('id')->on('marcas')->onDelete('set null');
            $table->text('descripcion');
            $table->string('codigo_barras', 12);
            $table->foreignId('departamento_id')->nullable()->references('id')->on('departamentos')->onDelete('set null');
            $table->foreignId('created_by_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('updated_by_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
