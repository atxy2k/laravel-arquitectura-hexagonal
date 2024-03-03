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
        Schema::create('existencias_por_almacen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreignId('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->unsignedBigInteger('cantidad');
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
        Schema::dropIfExists('existencias_por_almacen');
    }
};
