<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name_id' =>  Str::random(5),
            'user_name' =>  Str::random(10),
            'phone' =>  Str::random(11),
            'address' =>  Str::random(20),
            'yob' => Carbon::now(),
            'authority' => random_int(2,4),    
            'phone_parent' => Str::random(11),
            'year_old' =>  random_int(3,5),
            'password' => Hash::make('pa$$word'),
            'remember_token' => Str::random(10),
        ]);
    }
}
