<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id'            => Ulid::generate(),
                'name'          => 'driver1',
                'email'         => 'driver1@gmail.com',
                'password'      => 'password'
            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'driver2',
                'email'         => 'driver2@gmail.com',
                'password'      => 'password'
            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'driver3',
                'email'         => 'driver3@gmail.com',
                'password'      => 'password'
            ]
        ];

        Driver::query()->upsert($data, ['email']);
    }
}
