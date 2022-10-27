<?php

namespace App\Services\External\Broadcasts;

use App\Services\External\Broadcasts\Contracts\Broadcast;

class BroadcastFactory
{
    public static function make(string $source): Broadcast
    {
        $service = ucfirst($source);
        $service = "App\Services\External\Broadcasts\\{$service}";

        return new $service();
    }
}
