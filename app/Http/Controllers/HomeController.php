<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\ItemCat;
use App\Models\Numberal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $dataBoxes = [
            [
                'title'   => User::query()->count(),
                'icon'    => 'fa-user',
                'content' => 'Người dùng',
                'color'   => 'info',
                'route'   => route('users.index'),
            ],
            [
                'title'   => Role::query()->count(),
                'content' => ('Vai trò'),
                'icon'    => 'fa-users-cog',
                'color'   => 'success',
                'route'   => route('roles.index'),
            ],
            [
                'title'   => Activity::query()->count(),
                'content' => ('Nhật ký'),
                'icon'    => 'fa-file',
                'color'   => 'warning',
                'route'   => route('activity_logs.index'),
            ],
            [
                'title'   => Numberal::query()->count(),
                'content' => 'Sớ Sao',
                'icon'    => 'fa-file',
                'color'   => 'danger',
                'route'   => route('numberals.index'),
            ],
        ];

        $customers = Customer::query()->get();
        foreach ($customers as $customer) {
            $customer->yearUpdateCustomer();
        }

        return view('backend.home', ['dataBoxes' => $dataBoxes]);
    }

    /**
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function lang()
    {
        $lang    = config('app.locale');
        $strings = File::get(resource_path("lang/{$lang}.json"));
        $strings = json_decode($strings, JSON_FORCE_OBJECT);

        $toJson = collect(File::allFiles(resource_path("lang/$lang")))->filter(function ($file) {
            $module = $translation = $file->getBasename('.php');

            return ! in_array($module, ['pagination', 'validation', 'action']);
        })->flatMap(function ($file) use ($lang) {
            $module = $translation = $file->getBasename('.php');

            $translations = trans($translation, [], $lang);
            $datas        = [];

            if (is_array($translations)) {
                foreach ($translations as $key => $translation) {
                    $datas["{$module}.{$key}"] = $translation;
                }
            }

            return $datas;
        })->toArray();

        $datas = array_merge($strings, $toJson);
        $datas = json_encode($datas);

        header('Content-Type: text/javascript');
        echo 'window.lang = ' . $datas . ';';
        exit();
    }

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct()
    {
    }
}
