<?php

namespace Database\Seeders;

use App\Authorization\AppRoles;
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

        $this->call([
            RolePermissionSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Super Admin user',
            'email' => 'super@campuscal.com',
        ])->assignRole(AppRoles::SUPER_ADMIN);

        User::factory()->create([
            'name' => 'Admin user',
            'email' => 'admin@campuscal.com',
        ])->assignRole(AppRoles::ADMIN);

        User::factory()->create([
            'name' => 'Developer user',
            'email' => 'dev@campuscal.com',
        ])->assignRole(AppRoles::DEVELOPER);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@campuscal.com',
        ])->assignRole(AppRoles::REQUESTER);

        $campuses = Campus::factory(5)
            ->has(File::factory()->count(3), 'images')
            ->create();

        $space_resources = SpaceResource::factory(10)->create();

        $spaces = Space::factory(10)
            ->recycle($campuses)
            ->recycle($space_resources)
            ->has(File::factory()->count(3), 'images')
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
            ->has(Appointment::factory(5)->recycle($spaces), 'appointments')
            ->has(File::factory()->count(3), 'agreementContracts')
            ->recycle($audiences)
            ->create();
    }
}
