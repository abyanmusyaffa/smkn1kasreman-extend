<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'name' => '12 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '12 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '12 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '12 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '12 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '12 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '12 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '12 DPB',
                'major_id' => 4
            ],
            [
                'name' => '11 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '11 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '11 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '11 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '11 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '11 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '11 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '11 DPB',
                'major_id' => 4
            ],
            [
                'name' => '10 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '10 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '10 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '10 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '10 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '10 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '10 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '10 DPB',
                'major_id' => 4
            ],
        ]);
    }
}
