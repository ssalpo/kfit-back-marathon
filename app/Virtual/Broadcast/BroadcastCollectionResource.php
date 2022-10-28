<?php

namespace App\Virtual\Broadcast;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Broadcast collection resource")
 */
class BroadcastCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/BroadcastResource")
     * )
     *
     * @var array
     */
    private $data;

    /**
     * @OA\Property(
     *     title="meta"
     * )
     *
     * @var object
     */
    private $meta;

    /**
     * @OA\Property(
     *     title="links"
     * )
     *
     * @var object
     */
    private $links;
}
