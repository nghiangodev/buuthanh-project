<?php

use Illuminate\Database\Seeder;

class StarResolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\StarResolution::truncate();

        $datas = [
            [
                'name' => 'Sao La Hầu',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Thổ Tú',
                'created_by' => 1

            ],
            [
                'name' => 'Sao Thủy Diệu',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Thái Bạch',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Thái Dương',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Vân Hán',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Kế Đô',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Thái Âm',
                'created_by' => 1
            ],
            [
                'name' => 'Sao Mộc Đức',
                'created_by' => 1
            ],
        ];

        \App\Models\StarResolution::insert($datas);

    }
}
