<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGrandCategoryAPIRequest;
use App\Http\Requests\API\UpdateGrandCategoryAPIRequest;
use App\Models\GrandCategory;
use App\Repositories\GrandCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class GrandCategoryController
 */

class GrandCategoryAPIController extends AppBaseController
{
    protected $modelName='grand-categories';
    private GrandCategoryRepository $grandCategoryRepository;

    public function __construct(GrandCategoryRepository $grandCategoryRepo)
    {
        $this->grandCategoryRepository = $grandCategoryRepo;
    }

    /**
     * @OA\Get(
     *      path="/grand-categories",
     *      summary="getGrandCategoryList",
     *      tags={"GrandCategory"},
     *      description="Get all GrandCategories",
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
     *                  @OA\Items(ref="#/components/schemas/GrandCategory")
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
        $grandCategories = $this->grandCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $grandCategories->load('storeCategories');
        return $this->sendResponse($grandCategories->toArray(), 'Grand Categories retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/grand-categories",
     *      summary="createGrandCategory",
     *      tags={"GrandCategory"},
     *      description="Create GrandCategory",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/GrandCategory")
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
     *                  ref="#/components/schemas/GrandCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGrandCategoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $grandCategory = $this->grandCategoryRepository->create($input);

        return $this->sendResponse($grandCategory->toArray(), 'Grand Category saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/grand-categories/{id}",
     *      summary="getGrandCategoryItem",
     *      tags={"GrandCategory"},
     *      description="Get GrandCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of GrandCategory",
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
     *                  ref="#/components/schemas/GrandCategory"
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
        /** @var GrandCategory $grandCategory */
        $grandCategory = $this->grandCategoryRepository->find($id);

        if (empty($grandCategory)) {
            return $this->sendError('Grand Category not found');
        }

        return $this->sendResponse($grandCategory->toArray(), 'Grand Category retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/grand-category/{slug}",
     *      summary="getGrandCategoryItem",
     *      tags={"GrandCategory"},
     *      description="Get GrandCategory",
     *      @OA\Parameter(
     *          name="slug",
     *          description="slug of GrandCategory",
     *           @OA\Schema(
     *             type="string"
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
     *                  ref="#/components/schemas/GrandCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function showBySlug($slug=null): JsonResponse
    {
        /** @var GrandCategory $grandCategory */
        $grandCategory = $this->grandCategoryRepository->findSlug($slug);

        if (empty($grandCategory)) {
            return $this->sendError('Grand Category not found');
        }

        return $this->sendResponse($grandCategory->toArray(), 'Grand Category retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/grand-categories/{id}",
     *      summary="getGrandCategoryItem",
     *      tags={"GrandCategory"},
     *      description="Get GrandCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of GrandCategory",
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
     *                  ref="#/components/schemas/GrandCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getProduct($slug, Request $request): JsonResponse
    {
        /** @var GrandCategory $grandCategory */
        $grandCategory = GrandCategory::whereSlug($slug)->first();

        if (empty($grandCategory)) {
            return $this->sendError('Grand Category not found');
        }
        $limit = ($request->has('limit'))?$request->limit:5;
        $products=$grandCategory->products()->whereHas('productVariants')->limit($limit)->get();
        $products->load('productVariants');
        return $this->sendResponse($products->toArray(), 'get Product Grand Category retrieved successfully');
    }


    /**
     * @OA\Put(
     *      path="/grand-categories/{id}",
     *      summary="updateGrandCategory",
     *      tags={"GrandCategory"},
     *      description="Update GrandCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of GrandCategory",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/GrandCategory")
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
     *                  ref="#/components/schemas/GrandCategory"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGrandCategoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var GrandCategory $grandCategory */
        $grandCategory = $this->grandCategoryRepository->find($id);

        if (empty($grandCategory)) {
            return $this->sendError('Grand Category not found');
        }

        $grandCategory = $this->grandCategoryRepository->update($input, $id);

        return $this->sendResponse($grandCategory->toArray(), 'GrandCategory updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/grand-categories/{id}",
     *      summary="deleteGrandCategory",
     *      tags={"GrandCategory"},
     *      description="Delete GrandCategory",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of GrandCategory",
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
        /** @var GrandCategory $grandCategory */
        $grandCategory = $this->grandCategoryRepository->find($id);

        if (empty($grandCategory)) {
            return $this->sendError('Grand Category not found');
        }

        $grandCategory->delete();

        return $this->sendSuccess('Grand Category deleted successfully');
    }
}
