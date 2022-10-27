<?php

namespace App\Services\External\Broadcasts\Contracts;

use Illuminate\Http\Client\PendingRequest;

interface Broadcast
{
    public function client(): PendingRequest;

    /**
     * Create the live stream
     *
     * @param string $name
     * @param string $dateTime Date time in format "2021-06-16T01:01:01Z"
     *
     * @return array
     */
    public function createLive(string $name, string $dateTime): array;
}
