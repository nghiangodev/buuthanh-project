<?php

use App\Models\User;
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
        User::truncate();

        $faker = \Faker\Factory::create();

        $datas = [
            [
                'username' => 'admin',
                'name'     => $faker->name,
                'email'    => 'sino2901@gmail.com',
                'password' => \Hash::make('Admin1234'),
            ],
            [
                'username' => 'quy.ngo',
                'name'     => $faker->name,
                'email'    => 'nghia.nvt291@gmail.com',
                'password' => \Hash::make(1),
            ],
            [
                'username' => 'guess',
                'name'     => $faker->name,
                'email'    => 'nghia.nvt2911996@gmail.com',
                'password' => \Hash::make(1),
            ]
        ];

        User::insert($datas);

    }
}
