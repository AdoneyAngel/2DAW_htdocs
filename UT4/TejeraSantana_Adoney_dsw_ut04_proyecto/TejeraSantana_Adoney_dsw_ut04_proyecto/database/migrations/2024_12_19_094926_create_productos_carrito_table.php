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
        Schema::create('productos_carrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("producto")->nullable();
            $table->foreignId("usuario")->references("id")->on("usuarios")->cascadeOnDelete();
            $table->foreign("producto")->references("id")->on("productos")->cascadeOnDelete();
            $table->integer("unidades");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_carrito');
    }
};
