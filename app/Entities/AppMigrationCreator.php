<?php

namespace App\Entities;

use Illuminate\Database\Migrations\MigrationCreator;

class AppMigrationCreator extends MigrationCreator
{
	public function stubPath()
	{
		return database_path() . '/stubs';
	}
}
