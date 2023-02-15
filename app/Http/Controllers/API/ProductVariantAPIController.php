<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductVariantAPIRequest;
use App\Http\Requests\API\UpdateProductVariantAPIRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\ProductVariantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProductVariantController
 */

class ProductVariantAPIController extends AppBaseController
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepo)
    {
        $this->productVariantRepository = $productVariantRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/product-variants",
     *      summary="getProductVariantList",
     *      tags={"ProductVariant"},
     *      description="Get all ProductVariants",
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
     *                  @OA\Items(ref="#/components/schemas/ProductVariant")
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
        $productVariants = $this->productVariantRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productVariants->toArray(), 'Product Variants retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/product/{id}/variants",
     *      summary="getProductVariantList",
     *      tags={"ProductVariant"},
     *      description="Get Variants of Specific product",
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
     *                  @OA\Items(ref="#/components/schemas/ProductVariant")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getVariant(Product $product,Request $request): JsonResponse
    {
        $productVariants = $product->productVariants;

        return $this->sendResponse($productVariants->toArray(), 'Product Variants retrieved successfully');
    }
    /**
     * @OA\Post(
     *      path="/product-variants",
     *      summary="createProductVariant",
     *      tags={"ProductVariant"},
     *      description="Create ProductVariant",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductVariant")
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
     *                  ref="#/components/schemas/ProductVariant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductVariantAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $productVariant = $this->productVariantRepository->create($input);

        return $this->sendResponse($productVariant->toArray(), 'Product Variant saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/product-variants/{id}",
     *      summary="getProductVariantItem",
     *      tags={"ProductVariant"},
     *      description="Get ProductVariant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductVariant",
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
     *                  ref="#/components/schemas/ProductVariant"
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
        /** @var ProductVariant $productVariant */
        $productVariant = $this->productVariantRepository->find($id);

        if (empty($productVariant)) {
            return $this->sendError('Product Variant not found');
        }

        return $this->sendResponse($productVariant->toArray(), 'Product Variant retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/product-variants/{id}",
     *      summary="updateProductVariant",
     *      tags={"ProductVariant"},
     *      description="Update ProductVariant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductVariant",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/ProductVariant")
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
     *                  ref="#/components/schemas/ProductVariant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductVariantAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ProductVariant $productVariant */
        $productVariant = $this->productVariantRepository->find($id);

        if (empty($productVariant)) {
            return $this->sendError('Product Variant not found');
        }

        $productVariant = $this->productVariantRepository->update($input, $id);

        return $this->sendResponse($productVariant->toArray(), 'ProductVariant updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/product-variants/{id}",
     *      summary="deleteProductVariant",
     *      tags={"ProductVariant"},
     *      description="Delete ProductVariant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of ProductVariant",
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
        /** @var ProductVariant $productVariant */
        $productVariant = $this->productVariantRepository->find($id);

        if (empty($productVariant)) {
            return $this->sendError('Product Variant not found');
        }

        $productVariant->delete();

        return $this->sendSuccess('Product Variant deleted successfully');
    }
}
