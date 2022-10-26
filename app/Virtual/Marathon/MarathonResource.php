<?php

namespace App\Virtual\Marathon;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Marathon resource"
 * )
 */
class MarathonResource
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
     *     title="title",
     *     example="First marathon"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="preview",
     *     example="833968a0-3bab-4e91-b7ce-16865c1aed9b.jpg",
     *     description="Attached preview name after upload"
     * )
     *
     * @var string
     */
    private $preview;

    /**
     * @OA\Property(
     *     title="description"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *     title="start",
     *     description="Marathon start date"
     * )
     *
     * @var date
     */
    private $start;

    /**
     * @OA\Property(
     *     title="end",
     *     description="Marathon end date"
     * )
     *
     * @var date
     */
    private $end;

    /**
     * @OA\Property(
     *     title="status",
     *     description="Marathon status labels [wait, start, end]"
     * )
     *
     * @var string
     */
    private $status;

    /**
     * @OA\Property(
     *     title="trainers",
     *     description="List of trainers id",
     *     @OA\Schema(
     *       type="array",
     *       @OA\Items(type="integer")
     *     )
     * )
     *
     * @var string
     */
    private $trainers;

    /**
     * @OA\Property(
     *     title="components",
     *     @OA\Items(ref="#/components/schemas/MarathonComponentResource")
     * )
     *
     * @var array
     */
    private $components;
}
