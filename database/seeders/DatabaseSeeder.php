<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Audience;
use App\Models\Booking;
use App\Models\Campus;
use App\Models\File;
use App\Models\Institution;
use App\Models\InterestedParty;
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

        User::factory()->superAdmin()->create([
            'name' => 'Super Admin user',
            'email' => 'super@campuscal.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Admin user',
            'email' => 'admin@campuscal.com',
        ]);

        User::factory()->developer()->create([
            'name' => 'Developer user',
            'email' => 'dev@campuscal.com',
        ]);

        User::factory()->requester()->create([
            'name' => 'User',
            'email' => 'user@campuscal.com',
        ]);

        InterestedParty::factory(5)->create();

        $campuses = Campus::factory(5)
            ->hasImages(3)
            ->create();

        $space_resources = SpaceResource::factory(10)->create();

        $spaces = Space::factory(10)
            ->recycle($campuses)
            ->recycle($space_resources)
            ->hasImages(5)
            ->create();

        $audiences = Audience::factory(5)->sequence(
            ['name' => 'Estudiantes'],
            ['name' => 'Docentes'],
            ['name' => 'Administrativos'],
            ['name' => 'Egresados'],
            ['name' => 'Personal externo']
        )->create();

        $institutions = Institution::factory(5)->sequence(
            ['name' => 'Universidad Nacional de Colombia'],
            ['name' => 'Universidad de los Andes'],
            ['name' => 'Universidad Javeriana'],
            ['name' => 'Universidad del Rosario'],
        )->create();

        Institution::create(
            ['name' => 'Otra', 'id' => 0],
        );

        Booking::factory(50)
            ->has(Requester::factory()->recycle($institutions))
            ->has(Appointment::factory(5)->recycle($spaces), 'appointments')
            ->has(File::factory()->count(3), 'agreementContracts')
            ->recycle($audiences)
            ->create();
    }
}
