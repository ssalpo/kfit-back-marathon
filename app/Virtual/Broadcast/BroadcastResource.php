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
     *     title="status"
     * )
     *
     * @var string
     */
    private $status;

    /**
     * @OA\Property(
     *     title="marathon",
     *     nullable=true,
     *     @OA\Items(ref="#/components/schemas/MarathonResource")
     * )
     *
     * @var object
     */
    private $marathon;
}
