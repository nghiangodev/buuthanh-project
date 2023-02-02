<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class BladeServiceProvider.
 * @SuppressWarnings(PHPMD)
 */
class BladeServiceProvider extends ServiceProvider
{
	public function addCustomDirectives()
	{
		/*
		 * php implode() function.
		 *
		 * Usage: @implode($delimiter, $array)
		 */
		Blade::directive('implode', static function ($expression) {
			[$delimiter, $array] = self::parseMultipleArgs($expression);

			return "<?php echo implode({$delimiter}, {$array}); ?>";
		});

		/*
		 * Gán giá trị của biến
		 *
		 * Usage: @set($name, value)
		 */
		Blade::directive('set', static function ($expression) {
			[$name, $value] = self::parseMultipleArgs($expression);

			return "<?php {$name} = {$value}; ?>";
		});

		/*
		 * Tăng giá trị của biến + 1 (Chỉ sử dụng cho kiểu số).
		 *
		 * Usage: @increment($variable)
		 */
		Blade::directive('increment', static function ($expression) {
			return "<?php {$expression}++; ?>";
		});

		/*
		 * Giảm giá trị của biến -1 (Chỉ sử dụng cho kiểu số).
		 *
		 * Usage: @decrement($variable)
		 */
		Blade::directive('decrement', static function ($expression) {
			return "<?php {$expression}--; ?>";
		});

		/*
		 * Lấy giá trị biến môi trường.
		 *
		 * Usage: @getenv($name)
		 */
		Blade::directive('getenv', static function ($expression) {
			return "<?php echo getenv($expression); ?>";
		});

		/*
		 * Lấy giá trị biến trong file config.
		 *
		 * Usage: @config($name)
		 */
		Blade::directive('config', static function ($expression) {
			return "<?php echo config($expression); ?>";
		});

		/*
		 * Kiểm tra file có tồn tại hay không
		 *
		 * Usage: @iffileexists($filepath) ... @endiffileexists
		 */
		Blade::directive('iffileexists', static function ($expression) {
			return "<?php if(file_exists({$expression})): ?>";
		});

		Blade::directive('endiffileexists', static function () {
			return '<?php endif; ?>';
		});

		/*
		 * Kiểm tra tham số đầu tiên có phải là một thể hiện của tham số thừ hai hay không
		 *
		 * Usage: @instanceof($user, App\Modes\User) ... @endinstanceof
		 */
		Blade::directive('instanceof', function ($expression) {
			$expression = $this->parseMultipleArgs($expression);

			return "<?php if ({$expression->get(0)} instanceof {$expression->get(1)}) : ?>";
		});

		Blade::directive('endinstanceof', static function () {
			return '<?php endif; ?>';
		});

		/*
		 * Vòng lặp for
		 *
		 * Usage: @repeat(3) ...  @endrepeat
		 */
		Blade::directive('repeat', static function ($expression) {
			return "<?php for (\$iteration = 0 ; \$iteration < (int) {$expression}; \$iteration++): ?>";
		});

		Blade::directive('endrepeat', static function () {
			return '<?php endif; ?>';
		});
	}

	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		$this->addCustomDirectives();
	}

	/**
	 * Register the application services.
	 */
	public function register()
	{
	}

	/**
	 * Parse expression.
	 *
	 * @param string $expression
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function parseMultipleArgs($expression)
	{
		return collect(explode(',', $expression))->map(static function ($item) {
			return trim($item);
		});
	}

	/**
	 * Strip quotes.
	 *
	 * @param string $expression
	 *
	 * @return string
	 */
	public function stripQuotes($expression)
	{
		return str_replace(["'", '"'], '', $expression);
	}
}
