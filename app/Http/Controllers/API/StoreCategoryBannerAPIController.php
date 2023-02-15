<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreCategoryBannerAPIRequest;
use App\Http\Requests\API\UpdateStoreCategoryBannerAPIRequest;
use App\Models\StoreCategoryBanner;
use App\Repositories\StoreCategoryBannerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class StoreCategoryBannerController
 */

class StoreCategoryBannerAPIController extends AppBaseController
{
    private StoreCategoryBannerRepository $storeCategoryBannerRepository;

    public function __construct(StoreCategoryBannerRepository $storeCategoryBannerRepo)
    {
        $this->storeCategoryBannerRepository = $storeCategoryBannerRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/store-category-banners",
     *      summary="getStoreCategoryBannerList",
     *      tags={"StoreCategoryBanner"},
     *      description="Get all StoreCategoryBanners",
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
     *                  @OA\Items(ref="#/components/schemas/StoreCategoryBanner")
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
        $storeCategoryBanners = $this->storeCategoryBannerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($storeCategoryBanners->toArray(), 'Store Category Banners retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/store-category-banners",
     *      summary="createStoreCategoryBanner",
     *      tags={"StoreCategoryBanner"},
     *      description="Create StoreCategoryBanner",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreCategoryBanner")
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
     *                  ref="#/components/schemas/StoreCategoryBanner"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStoreCategoryBannerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $storeCategoryBanner = $this->storeCategoryBannerRepository->create($input);

        return $this->sendResponse($storeCategoryBanner->toArray(), 'Store Category Banner saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/store-category-banners/{id}",
     *      summary="getStoreCategoryBannerItem",
     *      tags={"StoreCategoryBanner"},
     *      description="Get StoreCategoryBanner",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategoryBanner",
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
     *                  ref="#/components/schemas/StoreCategoryBanner"
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
        /** @var StoreCategoryBanner $storeCategoryBanner */
        $storeCategoryBanner = $this->storeCategoryBannerRepository->find($id);

        if (empty($storeCategoryBanner)) {
            return $this->sendError('Store Category Banner not found');
        }

        return $this->sendResponse($storeCategoryBanner->toArray(), 'Store Category Banner retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/store-category-banners/{id}",
     *      summary="updateStoreCategoryBanner",
     *      tags={"StoreCategoryBanner"},
     *      description="Update StoreCategoryBanner",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategoryBanner",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreCategoryBanner")
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
     *                  ref="#/components/schemas/StoreCategoryBanner"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStoreCategoryBannerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var StoreCategoryBanner $storeCategoryBanner */
        $storeCategoryBanner = $this->storeCategoryBannerRepository->find($id);

        if (empty($storeCategoryBanner)) {
            return $this->sendError('Store Category Banner not found');
        }

        $storeCategoryBanner = $this->storeCategoryBannerRepository->update($input, $id);

        return $this->sendResponse($storeCategoryBanner->toArray(), 'StoreCategoryBanner updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/store-category-banners/{id}",
     *      summary="deleteStoreCategoryBanner",
     *      tags={"StoreCategoryBanner"},
     *      description="Delete StoreCategoryBanner",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreCategoryBanner",
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
        /** @var StoreCategoryBanner $storeCategoryBanner */
        $storeCategoryBanner = $this->storeCategoryBannerRepository->find($id);

        if (empty($storeCategoryBanner)) {
            return $this->sendError('Store Category Banner not found');
        }

        $storeCategoryBanner->delete();

        return $this->sendSuccess('Store Category Banner deleted successfully');
    }
}
