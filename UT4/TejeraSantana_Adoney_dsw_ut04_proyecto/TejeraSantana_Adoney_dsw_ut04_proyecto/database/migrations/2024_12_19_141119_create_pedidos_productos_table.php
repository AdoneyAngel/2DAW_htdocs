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
        Schema::create('pedidos_productos', function (Blueprint $table) {
            $table->id();
            $table->integer("unidades");
            $table->unsignedBigInteger("pedido")->nullable();
            $table->unsignedBigInteger("producto")->nullable();
            $table->foreign("producto")->references("id")->on("productos")->nullOnDelete();
            $table->foreign("pedido")->references("id")->on("pedidos")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_productos');
    }
};
