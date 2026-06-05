<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Read notification.
     */
    public function read(Request $request, $id)
    {
        $notification = $request->user()->unreadNotifications()->find($id)?->markAsRead() ?: false;

        return redirect($request->get('next', url()->previous()));
    }

    /**
     * Read all notifications.
     */
    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect($request->get('next', url()->previous()));
    }
}
