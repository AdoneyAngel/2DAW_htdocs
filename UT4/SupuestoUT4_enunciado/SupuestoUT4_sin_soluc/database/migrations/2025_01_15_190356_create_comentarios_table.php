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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Publicacion_ID")->nullable();
            $table->unsignedBigInteger("Usuario_Comentario")->nullable();
            $table->text("Texto_Comentario");
            $table->dateTime("Fecha_Comentario");
            $table->foreign("Publicacion_ID")->references("id")->on("publicaciones")->nullOnDelete();
            $table->foreign("Usuario_Comentario")->references("id")->on("usuarios")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
