<?php

namespace App\Virtual\Marathon;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Marathon collection resource")
 */
class MarathonCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/MarathonResource")
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
