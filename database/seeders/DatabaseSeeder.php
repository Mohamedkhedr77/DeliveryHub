<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole    = Role::firstOrCreate(['name' => 'admin']);
        $merchantRole = Role::firstOrCreate(['name' => 'merchant']); 
        $employeeRole = Role::firstOrCreate(['name' => 'employee']); 
        $driverRole   = Role::firstOrCreate(['name' => 'driver']);   

        $adminUser = User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@deliveryhub.com',
            'password' => bcrypt('password'), 
        ]);
        $adminUser->assignRole($adminRole);

        $employeeUser = User::factory()->create([
            'name' => 'Employee Account',
            'email' => 'employee@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $employeeUser->assignRole($employeeRole);
      
        $merchantUser = User::factory()->create([
            'name' => 'Merchant Shop',
            'email' => 'merchant@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $merchantUser->assignRole($merchantRole);

        $driverUser = User::factory()->create([
            'name' => 'Captain Driver',
            'email' => 'driver@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $driverUser->assignRole($driverRole);
    }
}