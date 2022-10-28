<?php

namespace App\Virtual\Broadcast;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Broadcast request"
 * )
 */
class BroadcastRequest
{
    /**
     * @OA\Property(
     *     title="title"
     * )
     *
     * @var string
     */
    private $title;
}
