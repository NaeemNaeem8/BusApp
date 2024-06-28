<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => fake()->name(),
            'email'             => fake()->safeEmail(),
            'phone'             => fake()->phoneNumber(),
            'password'          => 'password',
            'university_id'     => University::first()->id,
            'register_type'     => 'daily',
        ]);
    }
}
