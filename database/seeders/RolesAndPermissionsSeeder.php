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

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (CampusPermissions::cases() as $case) {
            Permission::create(['name' => $case->value]);
        }

        foreach (SpacePermissions::cases() as $case) {
            Permission::create(['name' => $case->value]);
        }

        foreach (BookingPermissions::cases() as $case) {
            Permission::create(['name' => $case->value]);
        }

        foreach (TeamPermissions::cases() as $case) {
            Permission::create(['name' => $case->value]);
        }

        foreach (DeveloperPermissions::cases() as $case) {
            Permission::create(['name' => $case->value]);
        }

        foreach (AppRoles::cases() as $role) {
            $this->syncPermissionsToRoles($role);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    function syncPermissionsToRoles(AppRoles $role): void
    {
        $permissions = [];

        switch ($role->name) {
            case AppRoles::REQUESTER:
                $permissions = [
                    CampusPermissions::VIEW->value,
                    SpacePermissions::VIEW->value,
                    CampusPermissions::LIST->value,
                    SpacePermissions::LIST->value,
                    BookingPermissions::CREATE->value,
                ];
                break;
            case AppRoles::ADMIN:
                $permissions = Permission::query()->whereNotIn('name', [
                    TeamPermissions::REMOVE_MEMBER->value,
                    TeamPermissions::UPDATE_ROLE->value,
                    TeamPermissions::INVITE_MEMBER->value,
                    TeamPermissions::VIEW_TEAM->value,
                    DeveloperPermissions::VIEW_PULSE->value,
                ])->get()->pluck('name')->toArray();
                break;
            case AppRoles::SUPER_ADMIN:
                $permissions = Permission::all()->pluck('name')->toArray();
                break;
            case AppRoles::DEVELOPER:
                $permissions = DeveloperPermissions::cases()->pluck('value')->toArray();
                break;
        }

        Role::create(['name' => $role])->syncPermissions($permissions);
    }
}

