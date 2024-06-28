<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysSeeder extends Seeder
{

    public function run()
    {
        $days = [
            [
                'name'              => 'السبت',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الأحد',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الاثنين',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الثلاثاء',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الاربعاء',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الخميس',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
            [
                'name'              => 'الجمعة',
                'created_at'        => now()->format('Y-m-d'),
                'updated_at'        => now()->format('Y-m-d'),
                'deleted_at'        => now()->format('Y-m-d')
            ],
        ];
        foreach ($days as $day) {
            Day::create($day);
        }
    }
}
