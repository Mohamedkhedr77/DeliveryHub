<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\Governorate;
use App\Models\User;
use App\Models\Status;
use App\Models\UndeliverableReason;
=======
use App\Models\User;
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

<<<<<<< HEAD
    public function run(): void
    {
<<<<<<< Updated upstream
        // Roles
=======
        $this->call(StatusSeeder::class);

        Governorate::insert([
            ['name' => 'Cairo', 'shipping_price' => 50.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Giza', 'shipping_price' => 55.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alexandria', 'shipping_price' => 90.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dakahlia', 'shipping_price' => 70.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Red Sea', 'shipping_price' => 150.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beheira', 'shipping_price' => 80.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fayoum', 'shipping_price' => 70.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gharbia', 'shipping_price' => 65.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ismailia', 'shipping_price' => 85.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Menofia', 'shipping_price' => 60.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minya', 'shipping_price' => 90.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qalyubia', 'shipping_price' => 60.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'New Valley', 'shipping_price' => 105.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Suez', 'shipping_price' => 90.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aswan', 'shipping_price' => 140.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Assiut', 'shipping_price' => 100.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Beni Suef', 'shipping_price' => 80.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Port Said', 'shipping_price' => 80.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Damietta', 'shipping_price' => 75.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sharkia', 'shipping_price' => 60.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'South Sinai', 'shipping_price' => 110.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kafr El Sheikh', 'shipping_price' => 65.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Matrouh', 'shipping_price' => 95.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Luxor', 'shipping_price' => 130.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qena', 'shipping_price' => 120.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'North Sinai', 'shipping_price' => 95.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sohag', 'shipping_price' => 110.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
>>>>>>> Stashed changes
=======
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
        $adminRole    = Role::create(['name' => 'admin']);
        $merchantRole = Role::create(['name' => 'merchant']); 
        $employeeRole = Role::create(['name' => 'employee']); 
        $driverRole   = Role::create(['name' => 'driver']);   

<<<<<<< HEAD
        // Users
        $adminUser = User::create([
            'name' => 'System Admin',
            'email' => 'admin@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->forceFill(['email_verified_at' => now()])->save();
        $adminUser->assignRole($adminRole);

        $employeeUser = User::create([
=======
        $adminUser = User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@deliveryhub.com',
            'password' => bcrypt('password'), 
        ]);
        $adminUser->assignRole($adminRole);

        $employeeUser = User::factory()->create([
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
            'name' => 'Employee Account',
            'email' => 'employee@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
<<<<<<< HEAD
        $employeeUser->forceFill(['email_verified_at' => now()])->save();
        $employeeUser->assignRole($employeeRole);

        $merchantUser = User::create([
=======
        $employeeUser->assignRole($employeeRole);

      
        $merchantUser = User::factory()->create([
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
            'name' => 'Merchant Shop',
            'email' => 'merchant@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
<<<<<<< HEAD
        $merchantUser->forceFill(['email_verified_at' => now()])->save();
        $merchantUser->assignRole($merchantRole);

        $driverUser = User::create([
=======
        $merchantUser->assignRole($merchantRole);

        $driverUser = User::factory()->create([
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
            'name' => 'Captain Driver',
            'email' => 'driver@deliveryhub.com',
            'password' => bcrypt('password'),
        ]);
<<<<<<< HEAD
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
=======
        $driverUser->assignRole($driverRole);
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
    }
}