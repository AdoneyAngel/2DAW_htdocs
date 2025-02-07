<?php

use App\Models\PlanTablaEntrenamiento;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    protected $model = PlanTablaEntrenamiento::class;

    public function up(): void
    {
        Schema::create('planestablasentrenamiento', function (Blueprint $table) {
            $table->id('id_plan_tabla');
            $table->unsignedBigInteger('id_plan');
            $table->unsignedBigInteger('id_tabla');
            $table->foreign('id_plan')->references('id_plan')->on('planesentrenamiento')->cascadeOnDelete();
            $table->foreign('id_tabla')->references('id_tabla')->on('tablasentrenamiento')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planestablaentrenamientos');
    }
};
