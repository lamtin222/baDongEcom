<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreDecorAPIRequest;
use App\Http\Requests\API\UpdateStoreDecorAPIRequest;
use App\Models\StoreDecor;
use App\Repositories\StoreDecorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class StoreDecorController
 */

class StoreDecorAPIController extends AppBaseController
{
    private StoreDecorRepository $storeDecorRepository;

    public function __construct(StoreDecorRepository $storeDecorRepo)
    {
        $this->storeDecorRepository = $storeDecorRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/store-decors",
     *      summary="getStoreDecorList",
     *      tags={"StoreDecor"},
     *      description="Get all StoreDecors",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/StoreDecor")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $storeDecors = $this->storeDecorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($storeDecors->toArray(), 'Store Decors retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/store-decors",
     *      summary="createStoreDecor",
     *      tags={"StoreDecor"},
     *      description="Create StoreDecor",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreDecor")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/StoreDecor"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStoreDecorAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        if(auth('sanctum')->user()->store_id){
            $storeDecor = $this->storeDecorRepository->create($input);

            return $this->sendResponse($storeDecor->toArray(), 'Store Decor saved successfully');
        }
        else{
            return $this->sendError("You must had a store before create a store decoration",401);
        }


    }

    /**
     * @OA\Get(
     *      path="/store-decors/{id}",
     *      summary="getStoreDecorItem",
     *      tags={"StoreDecor"},
     *      description="Get StoreDecor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreDecor",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/StoreDecor"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var StoreDecor $storeDecor */
        $storeDecor = $this->storeDecorRepository->find($id);

        if (empty($storeDecor)) {
            return $this->sendError('Store Decor not found');
        }

        return $this->sendResponse($storeDecor->toArray(), 'Store Decor retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/store-decors/{id}",
     *      summary="updateStoreDecor",
     *      tags={"StoreDecor"},
     *      description="Update StoreDecor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreDecor",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreDecor")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/StoreDecor"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStoreDecorAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var StoreDecor $storeDecor */
        $storeDecor = $this->storeDecorRepository->find($id);

        if (empty($storeDecor)) {
            return $this->sendError('Store Decor not found');
        }
        if (auth('sanctum')->user()->store_id == $id) {

            $storeDecor = $this->storeDecorRepository->update($input, $id);

            return $this->sendResponse($storeDecor->toArray(), 'StoreDecor updated successfully');
        }
        else
        {
            return $this->sendError('You are not authorized to update this Store Decoration');
        }
    }

    /**
     * @OA\Delete(
     *      path="/store-decors/{id}",
     *      summary="deleteStoreDecor",
     *      tags={"StoreDecor"},
     *      description="Delete StoreDecor",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreDecor",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var StoreDecor $storeDecor */
        $storeDecor = $this->storeDecorRepository->find($id);

        if (empty($storeDecor)) {
            return $this->sendError('Store Decor not found');
        }
        if (auth('sanctum')->user()->store_id == $id) {
            $storeDecor->delete();

            return $this->sendSuccess('Store Decor deleted successfully');
        }
        else
        {
            return $this->sendError('You are not authorized to delete this Store Decoration');
        }
    }
}
