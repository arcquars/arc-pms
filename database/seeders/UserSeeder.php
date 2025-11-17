<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit booking']);
        Permission::create(['name' => 'delete booking']);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'customer']);
        $role->givePermissionTo('edit booking');

        // or may be done by chaining
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['edit booking', 'delete booking']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); 

        // 3. Crear el Usuario Super Administrador
        // Se recomienda usar la factory para un código limpio.
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@ahotel.net'],
            [
                'name' => 'Super Administrator',
                // Hash::make() o bcrypt() asegura que la contraseña esté segura.
                'password' => bcrypt('password'), 
                'email_verified_at' => now(),
            ]
        );
        // Asignar el rol creado anteriormente
        $superAdmin->assignRole('super-admin');

        // 4. Crear el Usuario Administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@ahotel.net'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');
        
        // 5. Crear el Usuario Cliente (Customer)
        $customer = User::firstOrCreate(
            ['email' => 'customer@ahotel.net'],
            [
                'name' => 'Default Customer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole('customer');
    }
}
