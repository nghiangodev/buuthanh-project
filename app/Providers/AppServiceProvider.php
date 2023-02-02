<?php

namespace App\Providers;

use App\Entities\Core\Menu;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));

        Schema::defaultStringLength(200);

        $theme  = config('theme.name');
        $layout = "backend.layouts.themes.{$theme}";

        view()->share([
            'layout'      => $layout,
            'theme'       => $theme,
            'breadcrumbs' => [],
        ]);
        view()->composer(['backend.layouts.partials.menu._vertical_menu', 'backend.layouts.partials.menu._horizontal_menu'], static function ($view) {
            $menus = Menu::generate();

            return $view->with('menus', $menus);
        });
        view()->composer('*', static function ($view) {
            /** @var User $user */
            $user = auth()->user();

//			if (auth()->check()) {
//				$totalUnreadNotification = $user->unreadNotifications->count();
//				$notifications = $user->smallSetNotifications;
//			}

            $view->with([
                'currentUser'             => $user,
                'totalUnreadNotification' => 0,
                'notifications'           => [],
            ]);
        });

        // @noinspection PhpUndefinedClassInspection
        Cache::rememberForever('asset_version', static function () {
            return time();
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }
}
