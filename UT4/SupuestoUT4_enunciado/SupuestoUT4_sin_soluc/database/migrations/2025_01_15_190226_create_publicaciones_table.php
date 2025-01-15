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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("Usuario_ID")->nullable();
            $table->string("Nombre")->unique();
            $table->text("Descripcion");
            $table->string("URL_Archivo");
            $table->dateTime("Fecha_Publicacion");
            $table->foreign("Usuario_ID")->references("id")->on("usuarios")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
