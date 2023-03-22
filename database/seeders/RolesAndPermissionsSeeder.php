<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // permissions for library member

        $permissions = [
            'list books',
            'filter books',

            'add book',
            'edite book',
            'delete book',


            'list categories',

            'add category',
            'edite category',
            'delete category',

        ];
        // create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // give permissions to member role
        $role = Role::create(['name' => 'member'])
            ->givePermissionTo(['list books', 'filter books']);
        // give permission to librarian role
        $role = Role::create(['name' => 'librarian'])
            ->givePermissionTo([
                'list books',
                'filter books',

                'add book',
                'edite book',
                'delete book'
            ]);
        // give permission to admin role    
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'list books',
                'filter books',

                'add book',
                'edite book',
                'delete book',

                'list categories',
                'add category',
                'edite category',
                'delete category',
            ]);
}
}