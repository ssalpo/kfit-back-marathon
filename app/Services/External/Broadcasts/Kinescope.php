<?php

namespace App\Services\External\Broadcasts;

use App\Services\External\Broadcasts\Contracts\Broadcast;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Kinescope implements Broadcast
{
    public function client(): PendingRequest
    {
        return Http::withToken(config('services.kinescope.token'))
            ->baseUrl(config('services.kinescope.url'));
    }

    /**
     * @inheritDoc
     */
    public function createLive(string $name, string $dateTime): array
    {
        $stream = $this->client()->post(
            '/live/events',
            [
                'name' => $name,
                'type' => 'one-time',
                'scheduled_at' => $dateTime,
                'save_stream' => true,
                'folder_id' => config('services.kinescope.save_stream_folder_id'),
            ]
        )->json('data');

        return [
            'stream_id' => $stream['id'],
            'stream_link' => $stream['rtmp_url']
        ];
    }

}
