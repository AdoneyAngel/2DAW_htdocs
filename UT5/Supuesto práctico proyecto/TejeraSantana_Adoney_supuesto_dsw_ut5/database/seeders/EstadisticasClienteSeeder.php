<?php

namespace Database\Seeders;

use App\Models\EstadisticaCliente;
use App\Models\EstadisticasCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadisticasClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadisticaCliente::factory()->count(10)->create();
    }
}
