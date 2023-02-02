<?php

namespace App\Entities\Core;

use Illuminate\Support\Str;

class Menu
{
	/**
	 * @throws \Exception
	 * @return array|mixed
	 */
	public static function generate()
	{
		$menuModules = self::getMenuConfig();
		$menus       = [];
		foreach ($menuModules as $moduleKey => $menuModule) {
			if (! empty($menuModule['hide'])) {
				continue;
			}

			if (isset($menuModule['modules'])) {
				$modules = self::buildMenuFromModule($menuModule['modules']);

				$props = [
					'name'        => __(ucfirst(camel2words($moduleKey))),
					'icon'        => $menuModule['icon'],
					'menus'       => $modules,
					'activeClass' => self::getMenuActiveClass($modules),
				];

				$menus[] = $props;

				continue;
			}

			$singularModule = Str::singular($moduleKey);

			$props = self::buildMenuItem($singularModule, $moduleKey, $menuModule);

			if ($props) {
				$menus[] = $props;
			}
		}

		return $menus;
	}

	/**
	 * @param string $singularModule
	 * @param string $moduleKey
	 * @param array $menuModule
	 *
	 * @throws \Exception
	 * @return array|bool
	 */
	protected static function buildMenuItem($singularModule, $moduleKey, $menuModule)
	{
		$label = $menuModule['label'] ?? $singularModule;

		$permission  = $menuModule['permission'] ?? $singularModule;
		$canView     = can("view_{$permission}") || can("create_{$permission}");

		if (! $canView && $singularModule !== 'home' && empty($menuModule['byPass'])) {
			return false;
		}

		$route = ! empty($menuModule['route']) ? route($menuModule['route']) : 'javascript:void(0)';

		if ($route === 'javascript:void(0)' && \Route::has("{$moduleKey}.index")) {
			$route = route("{$moduleKey}.index");
		}

		return [
			'name'         => ! empty($menuModule['label']) ? __($menuModule['label']) : __(ucfirst(camel2words($label))),
			'route'        => $route,
			'downloadable' => ! empty($menuModule['downloadable']),
			'activeClass'  => self::getMenuItemActiveClass($menuModule['route'], true),
			'icon'         => $menuModule['icon'],
		];
	}

	/**
	 * @return mixed
	 */
	public static function getMenuConfig()
	{
		$json = file_get_contents(base_path() . '/routes/config/menus.json');

		// @noinspection PhpComposerExtensionStubsInspection
		return json_decode($json, JSON_FORCE_OBJECT);
	}

	/**
	 * @param array $menuModules
	 *
	 * @throws \Exception
	 * @return array
	 */
	private static function buildMenuFromModule($menuModules): array
	{
		$datas = [];
		foreach ($menuModules as $moduleKey => $menuModule) {
			$singularModuleName = Str::singular($moduleKey);
			$module             = $singularModuleName;

			if (strpos($moduleKey, 'logs') !== false) {
				$module = 'log';
			}
			$permission = $module;

			if (! empty($menuModule['permission'])) {
				$permission = $menuModule['permission'];
			}

			if (can("view_{$permission}") || can("create_{$permission}") || ! empty($menuModule['byPass'])) {
				$datas = self::buildSubMenu($menuModule ?? [], $moduleKey, $singularModuleName, $datas);
			}
		}
		$datas['activeClass'] = self::getMenuActiveClass($datas);

		return $datas;
	}

	/**
	 * @param array $arrays
	 *
	 * @return string
	 */
	public static function getMenuActiveClass($arrays): string
	{
		return \in_array('kt-menu__item--active', collect($arrays)->flatten()->toArray(), true) ? 'kt-menu__item--active' : '';
	}

	/**
	 * @param string $routeName
	 * @param bool $strictHighlight
	 *
	 * @SuppressWarnings(PHPMD)
	 * @return string
	 */
	private static function getMenuItemActiveClass($routeName, $strictHighlight = false): string
	{
		$currentRouteName = \Route::currentRouteName();

		if ($currentRouteName === $routeName) {
			return 'kt-menu__item--active';
		}

		if ($strictHighlight) {
			$configs     = explode('.', $routeName);
			$route       = $configs[0];
			$routeDetail = $configs[1] ?? '';

			$currentRouteconfigs = explode('.', $currentRouteName);
			$currentRoute        = $currentRouteconfigs[0];
			$currentRouteDetail  = $currentRouteconfigs[1] ?? '';

			if ($route) {
				if ($route !== $currentRoute) {
					return '';
				}

				if (stripos($currentRouteDetail, 'index') === false && $routeDetail !== $currentRouteDetail) {
					return '';
				}

				return 'kt-menu__item--active';
			}
		}

		return '';
	}

	/**
	 * @param array $menuModule
	 * @param string $moduleKey
	 * @param string $singularModule
	 * @param array $datas
	 *
	 * @throws \Exception
	 * @return array
	 */
	private static function buildSubMenu($menuModule, $moduleKey, $singularModule, $datas): array
	{
		if (! empty($menuModule['hide'])) {
			return $datas;
		}

		$props = self::buildMenuItem($singularModule, $moduleKey, $menuModule);

		if (! $menuModule) {
			$datas[] = $props;

			return $datas;
		}

		if (! empty($menuModule['icon'])) {
			$props['icon'] = $menuModule['icon'];

			if ($menuModule['parent'] !== '') {
				$datas[$menuModule['parent']][] = $props;

				return $datas;
			}
		}
		$datas[] = $props;

		return $datas;
	}
}
