<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::insert([
            ['id' => 1, 'name' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Assigned', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Out for Delivery', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Delivered', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Returned', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Cancelled', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
