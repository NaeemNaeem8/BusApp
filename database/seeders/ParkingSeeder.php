<?php

namespace Database\Seeders;

use App\Models\Parking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;

class ParkingSeeder extends Seeder
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
                'name'          => 'parking1',
            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'parking2',

            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'parking3',

            ]
        ];

        Parking::query()->upsert($data, ['id']);
    }
}
