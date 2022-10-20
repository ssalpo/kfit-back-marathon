<?php

namespace Tests\Helpers;

use App\Models\Marathon;

class MarathonHelper
{
    public static function getOneRandom()
    {
        Marathon::factory(10)->create();

        return Marathon::inRandomOrder()->first();
    }
}
