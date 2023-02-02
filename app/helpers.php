<?php

use App\Models\Customer;
use App\Models\User;

if ( ! function_exists('getRouteConfig')) {
    /**
     * Lấy nội dung file routes.json.
     *
     * @return stdClass
     */
    function getRouteConfig()
    {
        $json = file_get_contents(base_path() . '/routes/config/routes.json');

        // @noinspection PhpComposerExtensionStubsInspection
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('getPermissionConfig')) {
    /**
     * Lấy nội dung file routes.json.
     *
     * @return stdClass
     */
    function getPermissionConfig()
    {
        $json = file_get_contents(base_path() . '/database/files/permissions.json');

        // @noinspection PhpComposerExtensionStubsInspection
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('getMenuConfig')) {
    /**
     * Lấy nội dung file routes.json.
     *
     * @return stdClass
     */
    function getMenuConfig()
    {
        $json = file_get_contents(base_path() . '/routes/config/menus.json');

        // @noinspection PhpComposerExtensionStubsInspection
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('can')) {
    /**
     * Check quyền và vai trò.
     *
     * @param string|array $permissions
     *
     * @return bool
     * @throws Exception
     */
    function can($permissions)
    {
        /** @var User $user */
        $user = auth()->user();

        if ( ! $user) {
            return false;
        }

        if (is_array($permissions)) {
            return $user->hasAnyPermission($permissions);
        }

        return $user->can($permissions);
    }
}

if ( ! function_exists('cans')) {
    /**
     * Check nhiều quyền và vai trò.
     *
     * @param string|array $permissions
     *
     * @return array
     * @throws Exception
     */
    function cans($permissions)
    {
        /** @var User $user */
        $user = auth()->user();

        if ( ! $user) {
            return [];
        }

        $results = [];

        foreach ($permissions as $permission) {
            $results[] = can($permission);
        }

        return $results;
    }
}

if ( ! function_exists('user')) {
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|User
     */
    function user()
    {
        return auth()->user();
    }
}

if ( ! function_exists('isUseLogo')) {
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    function isUseLogo()
    {
        return config('theme.use_logo');
    }
}

if ( ! function_exists('getLogo')) {
    /**
     * @param string $filename
     * @param bool $ignoreEnv
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    function getLogo($filename = 'logo.png', $ignoreEnv = false)
    {
        if ($ignoreEnv) {
            return asset("assets/images/$filename");
        }

        $logo = config('theme.brand_logo');

        return $logo ? asset($logo) : asset("assets/images/$filename");
    }
}

if ( ! function_exists('getFavIcon')) {
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    function getFavIcon()
    {
        $logo = config('theme.fav_logo');

        return $logo ? asset($logo) : asset('assets/images/favicon.png');
    }
}

if ( ! function_exists('include_files_in_folder')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_files_in_folder($folder)
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            $it  = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if ( ! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    /** @noinspection PhpIncludeInspection */
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if ( ! function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        include_files_in_folder($folder);
    }
}
