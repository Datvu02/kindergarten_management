<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use carbon\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Classroom::factory(20)->create();
        User::factory()->create([
            'name_id' => 'admin',
            'user_name' => 'admin',
            'phone' =>  'admin',
            'address' =>  'admin',
            'yob' => Carbon::now(),
            'password' => Hash::make('pa$$word'),
            'authority' => 1, 
            'phone_parent' => 'admin',
            'year_old' =>  1,
        ]);
    }
}
