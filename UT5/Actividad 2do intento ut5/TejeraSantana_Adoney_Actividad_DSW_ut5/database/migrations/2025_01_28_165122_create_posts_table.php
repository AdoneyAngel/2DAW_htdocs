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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("titulo");
            $table->string("cuerpo");
            $table->string("imagen");
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->unsignedBigInteger("categoria_id")->nullable();
            $table->foreign("usuario_id")->references("id")->on("usuarios")->nullOnDelete();
            $table->foreign("categoria_id")->references("id")->on("categorias")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
