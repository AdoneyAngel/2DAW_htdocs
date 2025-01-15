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
            $table->id();
            $table->string("Nombre");
            $table->string("Nombre_Usuario", 100)->unique();
            $table->string("Correo_Electronico")->unique();
            $table->string("Contraseña");
            $table->dateTime("Fecha_Registro");
            $table->string("Foto_Perfil");
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
