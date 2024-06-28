<?php

namespace Database\Seeders;

use App\Models\Line;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Uid\Ulid;

class LineSeeder extends Seeder
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
                'name'          => 'line1'
            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'line2',

            ],
            [
                'id'            => Ulid::generate(),
                'name'          => 'line3',

            ]
        ];

        Line::query()->upsert($data, ['id']);
    }
}
