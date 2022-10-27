<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarathonRequest;
use App\Http\Resources\MarathonResource;
use App\Models\Marathon;
use App\Services\MarathonService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class MarathonController extends Controller
{
    private MarathonService $marathonService;

    public function __construct(MarathonService $marathonService)
    {
        $this->middleware('role:admin')->except('index', 'show');
        $this->middleware('role:guest|admin')->only('index');

        $this->marathonService = $marathonService;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/marathons",
     *     tags={"Marathons"},
     *     summary="Display a listing of the resource",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/MarathonCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return MarathonResource::collection(
            Marathon::with('trainers', 'broadcast')->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/marathons",
     *     tags={"Marathons"},
     *     summary="Store a newly created resource in storage.",
     *      @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/MarathonRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/MarathonResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param MarathonRequest $request
     * @return MarathonResource
     */
    public function store(MarathonRequest $request): MarathonResource
    {
        return new MarathonResource(
            $this->marathonService->store($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/marathons/{marathon}",
     *     tags={"Marathons"},
     *     summary="Display the specified resource.",
     *     @OA\Parameter(
     *         in="path",
     *         name="marathon",
     *         description="marathon model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/MarathonResource")
     *      )
     * )
     *
     * @param Marathon $marathon
     * @return MarathonResource
     */
    public function show(Marathon $marathon): MarathonResource
    {
        $marathon->load('trainers', 'broadcast');

        return new MarathonResource($marathon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/marathons/{marathon}",
     *     tags={"Marathons"},
     *     summary="Update the specified resource in storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="marathon",
     *         description="marathon model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/MarathonRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/MarathonResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param MarathonRequest $request
     * @param int $id
     * @return MarathonResource
     */
    public function update(MarathonRequest $request, int $id): MarathonResource
    {
        return new MarathonResource(
            $this->marathonService->update(
                $id, $request->validated()
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/marathons/{marathon}",
     *     tags={"Marathons"},
     *     summary="Remove the specified resource from storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="marathon",
     *         description="marathon model id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/MarathonResource")
     *     )
     * )
     *
     * @param int $id
     * @return MarathonResource
     */
    public function destroy(int $id): MarathonResource
    {
        return new MarathonResource(
            $this->marathonService->delete($id)
        );
    }
}
