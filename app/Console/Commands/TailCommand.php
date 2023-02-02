<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Class TailCommand.
 *
 * @SuppressWarnings(PHPMD)
 */
class TailCommand extends Command
{
	protected $signature = 'tail
                            {--lines=0 : Output the last number of lines}
                            {--H|hide-stack-traces : Filter out the stack traces}
                            {--grep : Grep specified string}
                            {--clear : Clear the terminal screen}';

	protected $description = 'Tail the latest logfile';

	/** @noinspection PhpUnusedParameterInspection */
	public function handle()
	{
		$logDirectory = storage_path('logs');

		$grep = $this->option('grep')
			? ' | grep "' . $this->option('grep') . '"'
			: '';

		$tailCommand = 'tail -f -n ' . $this->option('lines') . ' laravel.log' . $grep;

		$this->handleClearOption();

		Process::fromShellCommandline($tailCommand, $logDirectory)
			->setTty(false)
			->setTimeout(null)
			->run(function ($type, $line) {
				$this->handleClearOption();

				$this->output->write($line);
			});
	}

	protected function handleClearOption()
	{
		if (! $this->option('clear')) {
			return;
		}

		$this->output->write(sprintf("\033\143\e[3J"));
	}
}
