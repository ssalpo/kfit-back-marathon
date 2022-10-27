<?php

namespace App\Services;

use App\Models\Broadcast;
use App\Services\External\Broadcasts\BroadcastFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastService
{
    /**
     * Create new live stream
     *
     * @param int $broadcastId
     * @param string $sourceType
     * @return Model
     *
     * @throws \Exception
     */
    public function createLive(int $broadcastId, string $sourceType): Model
    {
        $broadcast = Broadcast::with('marathon')->findOrFail($broadcastId);

        $service = BroadcastFactory::make($sourceType);

        if (!$broadcast->title) {
            throw new \Exception('Заполните название трансляции!', 419);
        }

        $data = $service->createLive($broadcast->title, $broadcast->marathon->start);

        $broadcast->update(['source_data' => $data]);

        return $broadcast->refresh();
    }
}
