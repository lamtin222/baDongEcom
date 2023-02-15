<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreCategoryAPIRequest;
use App\Http\Requests\API\UpdateStoreCategoryAPIRequest;
use App\Models\StoreCategory;
use App\Repositories\StoreCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class StoreCategoryController
 */

class StoreCategoryAPIController extends AppBaseController
{
    protected $modelName='store-categories';
    private StoreCategoryRepository $storeCategoryRepository;

    public function __construct(StoreCategoryRepository $storeCategoryRepo)
    {
        $this->storeCategoryRepository = $storeCategoryRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/store-categories",
     *      summary="getStoreCategoryList",
     *      tags={"StoreCategory"},
     *      description="Get all StoreCategories",
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
     *                  @OA\Items(ref="#/components/schemas/StoreCategory")
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
        $storeCategories = $this->storeCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($storeCategories->toArray(), 'Store Categories retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/store/{store}/categories",
     *      summary="getStoreCategoryList",
     *      tags={"StoreCategory"},
     *      description="Get all Categories of a specific store",
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
     *                  @OA\Items(ref="#/components/schemas/StoreCategory")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getCategories(\App\Models\Store $store,Request $request): JsonResponse
    {
        $storeCategories = $store->storeCategories;

        return $this->sendResponse($storeCategories->toArray(), 'Store Categories retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/store-categories",
     *      summary="createStoreCategory",
     *      tags={"StoreCategory"},
     *      description="Create StoreCategory",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreCategory")
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
     *                  ref="#/components/schemas/StoreCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStoreCategoryAPIRequest $request)
    {
        $user = auth('sanctum')->user();
        if(!$user->store_id)
        return $this->sendError("You don't have permission to create a category");


        $input = $request->all();
        if($request->hasFile('image')) {

            $input['image'] = $this->handleUploadImage($request, 'image');
        }
        $input['store_id'] = auth('sanctum')->user()->store_id;

        $storeCategory = $this->storeCategoryRepository->create($input);

        return $this->sendResponse($storeCategory->toArray(), 'Store Category saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/store-categories/{id}",
     *      summary="getStoreCategoryItem",
     *      tags={"StoreCategory"},
     *      description="Get StoreCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategory",
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
     *                  ref="#/components/schemas/StoreCategory"
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
        /** @var StoreCategory $storeCategory */
        $storeCategory = $this->storeCategoryRepository->find($id);

        if (empty($storeCategory)) {
            return $this->sendError('Store Category not found');
        }

        return $this->sendResponse($storeCategory->toArray(), 'Store Category retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/store-categories/{id}",
     *      summary="updateStoreCategory",
     *      tags={"StoreCategory"},
     *      description="Update StoreCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategory",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreCategory")
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
     *                  ref="#/components/schemas/StoreCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStoreCategoryAPIRequest $request): JsonResponse
    {

        $input = $request->all();

        /** @var StoreCategory $storeCategory */
        $storeCategory = $this->storeCategoryRepository->find($id);

        $user = auth('sanctum')->user();

        if (empty($storeCategory)) {
            return $this->sendError('Store Category not found');
        }
        //check permission
        if(!$user->store_id || $storeCategory->store_id != $user->store_id)
        return $this->sendError("You don't have permission to update this category");

        if($request->hasFile('image')) {
            $this->removeFile($storeCategory->image);
            $input['image'] = $this->handleUploadImage($request, 'image');
        }

        $storeCategory = $this->storeCategoryRepository->update($input, $id);

        return $this->sendResponse($storeCategory->toArray(), 'StoreCategory updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/store-categories/{id}",
     *      summary="deleteStoreCategory",
     *      tags={"StoreCategory"},
     *      description="Delete StoreCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategory",
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
        /** @var StoreCategory $storeCategory */
        $storeCategory = $this->storeCategoryRepository->find($id);

        $user = auth('sanctum')->user();

        if (empty($storeCategory)) {
            return $this->sendError('Store Category not found');
        }

        if(!$user->store_id || $storeCategory->store_id != $user->store_id)
        return $this->sendError("You don't have permission to delete a category");

        $this->removeFile($storeCategory->image);
        $storeCategory->delete();

        return $this->sendSuccess('Store Category deleted successfully');
    }
}
