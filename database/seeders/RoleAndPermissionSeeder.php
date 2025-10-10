<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Filament Shield Permission Naming Convention အတိုင်း Permissions ဖန်တီးခြင်း
        $resources = ['User', 'Role', 'Permission', 'Post', 'Category'];
        $permissions = [];

        foreach ($resources as $resource) {
            $permissions[] = "ViewAny:{$resource}";
            $permissions[] = "View:{$resource}";
            $permissions[] = "Create:{$resource}";
            $permissions[] = "Update:{$resource}";
            $permissions[] = "Delete:{$resource}";
            $permissions[] = "Restore:{$resource}";
            $permissions[] = "ForceDelete:{$resource}";
            $permissions[] = "ForceDeleteAny:{$resource}";
            $permissions[] = "RestoreAny:{$resource}";
            $permissions[] = "Replicate:{$resource}";
            $permissions[] = "Reorder:{$resource}";
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles ဖန်တီးခြင်း
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Super Admin ကို permissions အားလုံးပေးခြင်း
        $superAdminRole->syncPermissions(Permission::all());

        // Admin ကို view နဲ့ update permissions တွေပေးခြင်း
        $adminPermissions = [];
        foreach ($resources as $resource) {
            $adminPermissions[] = "ViewAny:{$resource}";
            $adminPermissions[] = "View:{$resource}";
            $adminPermissions[] = "Update:{$resource}";
        }
        $adminRole->syncPermissions($adminPermissions);

        // User role မှာ basic permissions မပေးပါ
    }
}
