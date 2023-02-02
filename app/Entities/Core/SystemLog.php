<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 5/7/2018
 * Time: 12:00 PM.
 */

namespace App\Entities\Core;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Class SystemLog.
 * @SuppressWarnings(PHPMD)
 */
class SystemLog
{
	/**
	 * @var string file
	 */
	private static $file;

	private static $levelsClasses = [
		'debug'     => 'info',
		'info'      => 'info',
		'notice'    => 'info',
		'warning'   => 'warning',
		'error'     => 'danger',
		'critical'  => 'danger',
		'alert'     => 'danger',
		'emergency' => 'danger',
		'processed' => 'info',
		'failed'    => 'warning',
	];

	private static $levelsImgs = [
		'debug'     => 'far fa-info-circle',
		'info'      => 'far fa-info-circle',
		'notice'    => 'far fa-info-circle',
		'warning'   => 'far fa-exclamation-triangle',
		'error'     => 'far fa-exclamation-triangle',
		'critical'  => 'far fa-exclamation-triangle',
		'alert'     => 'far fa-exclamation-triangle',
		'emergency' => 'far fa-exclamation-triangle',
		'processed' => 'far fa-info-circle',
		'failed'    => 'far fa-exclamation-triangle',
	];

	/**
	 * Log levels that are used.
	 * @var array
	 */
	private static $logLevels = [
		'emergency',
		'alert',
		'critical',
		'error',
		'warning',
		'notice',
		'info',
		'debug',
		'processed',
		'failed',
	];

	public const MAX_FILE_SIZE = 52428800; // Why? Uh... Sorry

	/**
	 * @param string $file
	 *
	 * @throws \Exception
	 */
	public static function setFile($file): void
	{
		$file = self::pathToLogFile($file);

		if (app('files')->exists($file)) {
			self::$file = $file;
		}
	}

	/**
	 * @param string $file
	 *
	 * @throws \Exception
	 * @return string
	 */
	public static function pathToLogFile($file): string
	{
		$logsPath = storage_path('logs');

		if (app('files')->exists($file)) { // try the absolute path
			return $file;
		}
		$file = $logsPath . '/' . $file;
		// check if requested file is really in the logs directory
		if (\dirname($file) !== $logsPath) {
			throw new FileNotFoundException('No such log file');
		}

		return $file;
	}

	/**
	 * @return string
	 */
	public static function getFileName(): string
	{
		return basename(self::$file);
	}

	/**
	 * @throws FileNotFoundException
	 * @return array
	 */
	public static function all(): array
	{
		$log     = [];
		$pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';

		if (! self::$file) {
			$logFile = self::getFiles();

			if (! count($logFile)) {
				return [];
			}
			self::$file = $logFile[0];
		}

		if (app('files')->size(self::$file) > self::MAX_FILE_SIZE) {
			return;
		}
		$file = app('files')->get(self::$file);
		preg_match_all($pattern, $file, $headings);

		if (! \is_array($headings)) {
			return $log;
		}
		$logData = preg_split($pattern, $file);

		if ($logData[0] < 1) {
			array_shift($logData);
		}
		foreach ($headings as $h) {
			for ($i = 0, $j = count($h); $i < $j; $i++) {
				foreach (self::$logLevels as $level) {
					if (stripos($h[$i], '.' . $level) || stripos($h[$i], $level . ':')) {
						preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)' . $level . ': (.*?)( in .*?:[0-9]+)?$/i', $h[$i], $current);

						if (! isset($current[4])) {
							continue;
						}
						$log[] = [
							'context'     => $current[3],
							'level'       => $level,
							'level_class' => self::$levelsClasses[$level],
							'level_img'   => self::$levelsImgs[$level],
							'date'        => $current[1],
							'text'        => $current[4],
							'in_file'     => $current[5] ?? null,
							'stack'       => preg_replace("/^\n*/", '', $logData[$i]),
						];
					}
				}
			}
		}

		return array_reverse($log);
	}

	/**
	 * @param string $basename
	 *
	 * @return array
	 */
	public static function getFiles($basename = null): array
	{
		$files = glob(storage_path() . '/logs/' . (\function_exists('config') ? config('logviewer.pattern', '*.log') : '*.log'));
		$files = array_reverse($files);
		$files = array_filter($files, 'is_file');

		if ($basename && \is_array($files)) {
			foreach ($files as $k => $file) {
				$files[$k] = basename($file);
			}
		}

		return array_values($files);
	}

	public static function getLevels(): array
	{
		return self::$logLevels;
	}
}
