<?php

namespace Database\Seeders;

use App\Authorization\AppRoles;
use App\Authorization\BookingPermissions;
use App\Authorization\CampusPermissions;
use App\Authorization\DeveloperPermissions;
use App\Authorization\SpacePermissions;
use App\Authorization\TeamPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => CampusPermissions::CREATE->value]);
        Permission::create(['name' => CampusPermissions::VIEW->value]);
        Permission::create(['name' => CampusPermissions::LIST->value]);
        Permission::create(['name' => CampusPermissions::UPDATE->value]);
        Permission::create(['name' => CampusPermissions::DELETE->value]);

        Permission::create(['name' => SpacePermissions::CREATE->value]);
        Permission::create(['name' => SpacePermissions::VIEW->value]);
        Permission::create(['name' => SpacePermissions::LIST->value]);
        Permission::create(['name' => SpacePermissions::UPDATE->value]);
        Permission::create(['name' => SpacePermissions::DELETE->value]);

        Permission::create(['name' => BookingPermissions::CREATE->value]);
        Permission::create(['name' => BookingPermissions::VIEW->value]);
        Permission::create(['name' => BookingPermissions::LIST->value]);
        Permission::create(['name' => BookingPermissions::UPDATE->value]);
        Permission::create(['name' => BookingPermissions::DELETE->value]);

        Permission::create(['name' => TeamPermissions::INVITE_MEMBER->value]);
        Permission::create(['name' => TeamPermissions::UPDATE_ROLE->value]);
        Permission::create(['name' => TeamPermissions::REMOVE_MEMBER->value]);
        Permission::create(['name' => TeamPermissions::VIEW_TEAM->value]);

        Permission::create(['name' => DeveloperPermissions::VIEW_PULSE->value]);

        Role::create(['name' => AppRoles::REQUESTER])->syncPermissions([
            CampusPermissions::VIEW->value,
            SpacePermissions::VIEW->value,
            CampusPermissions::LIST->value,
            SpacePermissions::LIST->value,
            BookingPermissions::CREATE->value,
        ]);

        Role::create(['name' => AppRoles::ADMIN])->syncPermissions(Permission::query()->whereNotIn('name', [
            TeamPermissions::REMOVE_MEMBER->value,
            TeamPermissions::UPDATE_ROLE->value,
            TeamPermissions::INVITE_MEMBER->value,
            TeamPermissions::VIEW_TEAM->value,
            DeveloperPermissions::VIEW_PULSE->value,
        ]));

        Role::create(['name' => AppRoles::SUPER_ADMIN]);

        Role::create(['name' => AppRoles::DEVELOPER]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
