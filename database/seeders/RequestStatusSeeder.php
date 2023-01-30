<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('requests_statuses')->delete();

        \DB::table('requests_statuses')->insert([
            [
                'id'         => 1,
                'status_code'         => 1,
                'name'       => 'Requested',
            ],
            [
                'id'         => 2,
                'status_code'         => 2,
                'name'       => 'Connected',
            ],
            [
                'id'         => 3,
                'status_code'         => 3,
                'name'       => 'Removed',
            ],
        ]);
    }
}
