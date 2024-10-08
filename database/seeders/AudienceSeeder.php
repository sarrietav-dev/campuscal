<?php

namespace Database\Seeders;

use App\Models\Audience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Audience::factory(5)->sequence(
            ['name' => 'Estudiantes'],
            ['name' => 'Docentes'],
            ['name' => 'Administrativos'],
            ['name' => 'Egresados'],
            ['name' => 'Personal externo']
        )->create();
    }
}
