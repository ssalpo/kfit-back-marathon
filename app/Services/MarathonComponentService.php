<?php

namespace App\Services;

use App\Models\MarathonComponent;
use Illuminate\Database\Eloquent\Relations\Relation;

class MarathonComponentService
{
    /**
     * Attach broadcast to marathon
     *
     * @param int $marathonId
     * @param int $broadcastId
     * @return MarathonComponent
     */
    public function addBroadcast(int $marathonId, int $broadcastId): MarathonComponent
    {
        return MarathonComponent::create([
            'marathon_id' => $marathonId,
            'model_type' => 'broadcast',
            'model_id' => $broadcastId,
        ]);
    }
}
