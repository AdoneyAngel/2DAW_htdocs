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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('email', 255)->unique();
            $table->string("token", 100)->nullable();
            $table->string('clave', 255);
            $table->unsignedBigInteger('id_tipo_usuario')->nullable();
            $table->foreign('id_tipo_usuario')->references('id_tipo_usuario')->on('tipousuario')->nullOnDelete();
            $table->date('fecha_registro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
