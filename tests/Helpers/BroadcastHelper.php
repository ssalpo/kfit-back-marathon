<?php

namespace Tests\Helpers;

use App\Models\Broadcast;

class BroadcastHelper
{
    public static function getOneRandom()
    {
        Broadcast::factory(10)->create();

        return Broadcast::inRandomOrder()->first();
    }
}
