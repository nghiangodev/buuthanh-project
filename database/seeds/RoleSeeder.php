<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    Schema::disableForeignKeyConstraints();
	    \Illuminate\Support\Facades\DB::table('roles')->truncate();
	    Schema::enableForeignKeyConstraints();

        $roleNames = [
            [
                'name' => 'Quản trị viên (IT)'
            ],
        ];

        \App\Models\Role::insert($roleNames);
    }
}
