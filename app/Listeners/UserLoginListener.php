<?php

namespace App\Listeners;

use App\Events\SystemLogEvent;
use App\Events\UserLoginEvent;
use App\Models\SysLoginLog;
use Route;
use Request;

class UserLoginListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserLoginEvent $event
     * @return void
     */
    public function handle(UserLoginEvent $event)
    {

        $log = new SysLoginLog();
        $log->login_name = $event->name;
        $log->ip_addr = Request::ip();
        $log->user_agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 250);
        $log->status = $event->status;
        $log->msg = substr($event->message, 0, 64);
        $log->login_time = date('Y-m-d H:i:s');

        $log->save();
    }
}
