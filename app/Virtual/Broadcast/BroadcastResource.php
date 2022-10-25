<?php

namespace App\Virtual\Broadcast;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Broadcast resource"
 * )
 */
class BroadcastResource
{
    /**
     * @OA\Property(
     *     title="id"
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     title="title"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="marathon",
     *     @OA\Items(ref="#/components/schemas/MarathonResource")
     * )
     *
     * @var array
     */
    private $marathon;
}
