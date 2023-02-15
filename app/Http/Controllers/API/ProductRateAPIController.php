<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductRateAPIRequest;
use App\Http\Requests\API\UpdateProductRateAPIRequest;
use App\Models\ProductRate;
use App\Repositories\ProductRateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductRateController
 */

class ProductRateAPIController extends AppBaseController
{
    private ProductRateRepository $productRateRepository;

    public function __construct(ProductRateRepository $productRateRepo)
    {
        $this->productRateRepository = $productRateRepo;
    }

    /**
     * @OA\Get(
     *      path="/product-rates",
     *      summary="getProductRateList",
     *      tags={"ProductRate"},
     *      description="Get all ProductRates",
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
     *                  @OA\Items(ref="#/components/schemas/ProductRate")
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
        $productRates = $this->productRateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productRates->toArray(), 'Product Rates retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/product-rates",
     *      summary="createProductRate",
     *      tags={"ProductRate"},
     *      description="Create ProductRate",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductRate")
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
     *                  ref="#/components/schemas/ProductRate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductRateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $productRate = $this->productRateRepository->create($input);

        return $this->sendResponse($productRate->toArray(), 'Product Rate saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/product-rates/{id}",
     *      summary="getProductRateItem",
     *      tags={"ProductRate"},
     *      description="Get ProductRate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductRate",
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
     *                  ref="#/components/schemas/ProductRate"
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
        /** @var ProductRate $productRate */
        $productRate = $this->productRateRepository->find($id);

        if (empty($productRate)) {
            return $this->sendError('Product Rate not found');
        }

        return $this->sendResponse($productRate->toArray(), 'Product Rate retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/product-rates/{id}",
     *      summary="updateProductRate",
     *      tags={"ProductRate"},
     *      description="Update ProductRate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductRate",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductRate")
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
     *                  ref="#/components/schemas/ProductRate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductRateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProductRate $productRate */
        $productRate = $this->productRateRepository->find($id);

        if (empty($productRate)) {
            return $this->sendError('Product Rate not found');
        }

        $productRate = $this->productRateRepository->update($input, $id);

        return $this->sendResponse($productRate->toArray(), 'ProductRate updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/product-rates/{id}",
     *      summary="deleteProductRate",
     *      tags={"ProductRate"},
     *      description="Delete ProductRate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductRate",
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
        /** @var ProductRate $productRate */
        $productRate = $this->productRateRepository->find($id);

        if (empty($productRate)) {
            return $this->sendError('Product Rate not found');
        }

        $productRate->delete();

        return $this->sendSuccess('Product Rate deleted successfully');
    }
}
