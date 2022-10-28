<?php

namespace App\Virtual\Marathon;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Marathon component resource"
 * )
 */
class MarathonComponentResource
{
    /**
     * @OA\Property(
     *     title="broadcast",
     *     @OA\Items(ref="#/components/schemas/BroadcastResource")
     * )
     *
     * @var array
     */
    private $broadcast;
}
