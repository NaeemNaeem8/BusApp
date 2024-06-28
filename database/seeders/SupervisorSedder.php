<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Supervisor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supervisor::create([
            'name'      => fake()->name(),
            'email'     => 'supervisor@gamil.com',
            'password'  => 'password',
        ]);

        Admin::create([
            'name' => fake()->name(),
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);
    }
}
