<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class UserLoginEvent
{
    use SerializesModels;

    public $name = '';
    public $status = 0;
    public $message = 'success';

    /**
     * @param string $name
     * @param int $status
     * @param string $message
     */
    public function __construct(string $name, int $status, string $message)
    {
        $this->name = $name;
        $this->status = $status;
        $this->message = $message;
    }
}
