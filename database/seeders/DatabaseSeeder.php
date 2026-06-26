<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use App\Models\UndeliverableReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Roles
        $adminRole    = Role::create(['name' => 'admin']);
        $merchantRole = Role::create(['name' => 'merchant']); 
        $employeeRole = Role::create(['name' => 'employee']); 
        $driverRole   = Role::create(['name' => 'driver']);   

        // Users
        $adminUser = User::create([
            'name' => 'System Admin',
            'email' => 'admin@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->forceFill(['email_verified_at' => now()])->save();
        $adminUser->assignRole($adminRole);

        $employeeUser = User::create([
            'name' => 'Employee Account',
            'email' => 'employee@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $employeeUser->forceFill(['email_verified_at' => now()])->save();
        $employeeUser->assignRole($employeeRole);

        $merchantUser = User::create([
            'name' => 'Merchant Shop',
            'email' => 'merchant@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $merchantUser->forceFill(['email_verified_at' => now()])->save();
        $merchantUser->assignRole($merchantRole);

        $driverUser = User::create([
            'name' => 'Captain Driver',
            'email' => 'driver@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $driverUser->forceFill(['email_verified_at' => now()])->save();
        $driverUser->assignRole($driverRole);

        // Statuses
        $statuses = ['Pending', 'Assigned', 'Out for Delivery', 'Delivered', 'Returned', 'Cancelled'];
        foreach ($statuses as $name) {
            Status::firstOrCreate(['name' => $name]);
        }

        // Undeliverable Reasons
        $reasons = [
            'العنوان خطأ',
            'عدم رد العميل',
            'رفض العميل الاستلام',
        ];
        foreach ($reasons as $reason) {
            UndeliverableReason::firstOrCreate(['name' => $reason]);
        }
    }
}