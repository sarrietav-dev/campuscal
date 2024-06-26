<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Audience;
use App\Models\Booking;
use App\Models\Campus;
use App\Models\File;
use App\Models\Requester;
use App\Models\Space;
use App\Models\SpaceResource;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $campuses = Campus::factory(5)
            ->has(File::factory())
            ->create();

        $space_resources = SpaceResource::factory(10)->create();

        $spaces = Space::factory(10)
            ->recycle($campuses)
            ->recycle($space_resources)
            ->has(File::factory())
            ->create();

        $audiences = Audience::factory(5)->sequence(
            ['name' => 'Estudiantes'],
            ['name' => 'Docentes'],
            ['name' => 'Administrativos'],
            ['name' => 'Egresados'],
            ['name' => 'Personal externo']
        )->create();

        Booking::factory(50)
            ->has(Requester::factory())
            ->has(Appointment::factory(5)->recycle($spaces))
            ->recycle($audiences)
            ->create();
    }
}
