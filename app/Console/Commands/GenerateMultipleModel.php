<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMultipleModel extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:models {table}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create multiple model file';

	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$table = $this->argument('table');

		if (strpos($table, ',') !== false) {
			$tables = explode(',', $table);
		} else {
			$tables = [$table];
		}

		foreach ($tables as $table) {
			$this->call('code:models', [
				'--table' => $table,
			]);
		}
	}
}
