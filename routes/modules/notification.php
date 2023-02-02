<?php

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

Route::prefix('notifications')->name('notifications.')->group(static function () {
    Route::get('load-more/{page}', static function ($page = 1) {
        $offset = $page * 10;
        /** @var User $user */
        $user = auth()->user();

        if (auth()->check()) {
            $notifications = $user->notifications()->offset($offset)->limit(10)->get();
        }

        return response()->json([
            'notifications' => $notifications ?? [],
        ]);

    })->middleware(['auth', 'active'])->name('load_more');

    Route::post('mark/all/read/', static function () {
        /** @var User $user */
        $user = auth()->user();

        $user->unreadNotifications()->update(['read_at' => now()]);

    })->middleware(['auth', 'active'])->name('mark_all_read');

    Route::post('read/single/{notification}', static function (DatabaseNotification $notification = null) {
        if ($notification) {
            $notification->markAsRead();
        }
    })->middleware(['auth', 'active'])->name('mark_single_read');
});