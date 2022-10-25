<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BroadcastRequest;
use App\Http\Resources\BroadcastResource;
use App\Models\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class BroadcastController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/broadcasts",
     *     tags={"Broadcasts"},
     *     summary="Display a listing of the resource",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/BroadcastCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return BroadcastResource::collection(
            Broadcast::with('marathon')->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/broadcasts",
     *     tags={"Broadcasts"},
     *     summary="Store a newly created resource in storage.",
     *     @OA\RequestBody(
     *        @OA\JsonContent(ref="#/components/schemas/BroadcastRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BroadcastResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param BroadcastRequest $request
     * @return BroadcastResource
     */
    public function store(BroadcastRequest $request): BroadcastResource
    {
        return BroadcastResource::make(
            Broadcast::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/broadcasts/{broadcast}",
     *     tags={"Broadcasts"},
     *     summary="Display the specified resource.",
     *     @OA\Parameter(
     *         in="path",
     *         name="broadcast",
     *         description="broadcast model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/BroadcastResource")
     *      )
     * )
     *
     * @param Broadcast $broadcast
     * @return BroadcastResource
     */
    public function show(Broadcast $broadcast): BroadcastResource
    {
        return BroadcastResource::make($broadcast);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/broadcasts/{broadcast}",
     *     tags={"Broadcasts"},
     *     summary="Update the specified resource in storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="broadcast",
     *         description="broadcast model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/BroadcastRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BroadcastResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param BroadcastRequest $request
     * @param Broadcast $broadcast
     * @return BroadcastResource
     */
    public function update(BroadcastRequest $request, Broadcast $broadcast): BroadcastResource
    {
        $broadcast->update($request->validated());

        return BroadcastResource::make($broadcast->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/Broadcasts/{Broadcast}",
     *     tags={"Broadcasts"},
     *     summary="Remove the specified resource from storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="Broadcast",
     *         description="Broadcast model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BroadcastResource")
     *     )
     * )
     *
     * @param Broadcast $broadcast
     * @return BroadcastResource
     */
    public function destroy(Broadcast $broadcast): BroadcastResource
    {
        $broadcast->delete();

        return BroadcastResource::make($broadcast);
    }
}
