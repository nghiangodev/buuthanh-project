<?php

use Illuminate\Support\Str;

try {
	Breadcrumbs::for('home', static function ($trail) {
		$trail->push(__('Home'), route('home'));
	});

	$routeArr = getRouteConfig();

	$views = collect($routeArr)->flatten();

	$actions = ['index', 'create', 'edit', 'show'];
	foreach ($views as $view) {
		foreach ($actions as $action) {
			if ($action == 'index') {
				Breadcrumbs::for("{$view}.{$action}", static function ($trail, $label = null) use ($view) {
					$trail->parent('home');
					if ($label) {
						$labelName = $label;
					} else {
						$viewSingular = Str::singular($view);
						$viewUc       = ucfirst(variablize($viewSingular));
						if (class_exists("App\\Models\\{$viewUc}")) {
							$reflect   = new \ReflectionClass("App\\Models\\$viewUc");
							$labelName = $reflect->getMethod('classLabel')->invoke($reflect->newInstance());
						} else {
							$labelName = __(humanize($viewSingular));
						}
					}
					$trail->push($labelName, route("{$view}.index"));
				});
			} else {
				Breadcrumbs::for("{$view}.{$action}", static function ($trail, $params) use ($view, $action) {
					$model = $params['model'];
					$label = $params['label'] ?? null;

					$title = __('Add new');

					$trail->parent("{$view}.index");
					if ($action === 'edit') {
						$title = __('Edit');
//                        $options       = $params['options'];
//                        $isNotShowView = isset($options['showView']) && $options['showView'] === false;
//                        if ( ! $isNotShowView) {
//                            $detailName = $model->{$model->displayAttribute};
//                            $trail->push($detailName ?? '', route("{$view}.show", $model));
//                        }
					}
					if ($action === 'show' && ! $label) {
						$detailName = $model->{$model->displayAttribute};
						$title      = $detailName ? __('View detail') . " $detailName" : __('View detail');
					}

					$title = $label ?? $title;

					$trail->push($title, route("{$view}.{$action}", $model));
				});
			}
		}
	}

	require __DIR__ . '/custom.php';
} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {
	dump($e->getMessage());
	die;
}