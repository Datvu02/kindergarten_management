<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("classroom")->insert([
            'class_name' => fake()->class_name(),
            'class_name' => fake()->class_name(),
            'homeroom_teacher_id' => fake()->homeroom_teacher_id(),
        ]);
    }
}
