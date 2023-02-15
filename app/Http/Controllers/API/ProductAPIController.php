<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductAPIRequest;
use App\Http\Requests\API\UpdateProductAPIRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Store;
use App\Models\StoreCategory;

/**
 * Class ProductController
 */

class ProductAPIController extends AppBaseController
{
    private ProductRepository $productRepository;
    protected $modelName='products';
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/products",
     *      summary="getProductList",
     *      tags={"Product"},
     *      description="Get all Products",
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
     *                  @OA\Items(ref="#/components/schemas/Product")
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
        $products = $this->productRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/store/{store}/products",
     *      summary="getProductListByStore",
     *      tags={"Product"},
     *      description="Get all Products of specific store",
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
     *                  @OA\Items(ref="#/components/schemas/Product")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getProductsByStore(Store $store,Request $request): JsonResponse
    {
        $products = $store->products;

        $products=$products->makeHidden(['description','body','laravel_through_key']);
        $products->load('productVariants');

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/store-categories/{storeCategory}/products",
     *      summary="getProductListByCategory",
     *      tags={"Product"},
     *      description="Get all Products of specific category",
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
     *                  @OA\Items(ref="#/components/schemas/Product")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getProductsByCategory(StoreCategory $storeCategory,Request $request): JsonResponse
    {
        $products = $storeCategory->products;
        $products=$products->makeHidden(['description','body']);

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
    public function getProductsByCategorySlug($slug,Request $request): JsonResponse
    {

       $storeCategory= StoreCategory::whereSlug($slug)->first();
        if (!$storeCategory) {
            return $this->sendError('No store category found');
        }
        $limit = ($request->has('limit'))?$request->limit:5;

        $products =$storeCategory->products()->whereHas('productVariants')->limit($limit)->latest()->get();
        $products=$products->makeHidden(['description','body']);
        $products->load('productVariants');

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/products",
     *      summary="createProduct",
     *      tags={"Product"},
     *      description="Create Product",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Product")
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
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductAPIRequest $request)
    {
        $input = $request->all();
        if($request->hasFile('images')) {
            $input['images'] = $this->handleUploadMultipleImage($request, 'images');
        }
        $product = $this->productRepository->create($input);

        return $this->sendResponse($product->toArray(), 'Product saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/products/{id}",
     *      summary="getProductItem",
     *      tags={"Product"},
     *      description="Get Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
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
     *                  ref="#/components/schemas/Product"
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
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        return $this->sendResponse($product->toArray(), 'Product retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/product/{slug}",
     *      summary="getProductItem",
     *      tags={"Product"},
     *      description="Get Product",
     *      @OA\Parameter(
     *          name="slug",
     *          description="slug of Product",
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
     *                  ref="#/components/schemas/Product"
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
        /** @var Product $product */
        $product = $this->productRepository->findSlug($slug)->first();

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        $product->load('category');
        $product->load('productVariants');
        return $this->sendResponse($product, 'Product retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/product/{slug}/related-products",
     *      summary="get Related ProductItem",
     *      tags={"Product"},
     *      description="Get Product",
     *      @OA\Parameter(
     *          name="slug",
     *          description="slug of Product",
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
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function relatedProducts($slug=null,Request $request): JsonResponse
    {
        /** @var Product $product */
        $product = $this->productRepository->findSlug($slug)->first();
        $limit = ($request->has('limit')) ? $request->get('limit') : 4;
        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        $products = Product::whereHas('productVariants')->where('category_id', $product->category_id)->latest()->limit($limit)->get();



        $products->load('category');
        $products->load('productVariants');
        return $this->sendResponse($products, 'Product retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/products/{id}",
     *      summary="updateProduct",
     *      tags={"Product"},
     *      description="Update Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Product")
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
     *                  ref="#/components/schemas/Product"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }
        if($request->hasFile('images')) {

            $content = $this->handleUploadMultipleImage($request, 'images');

            if (!is_null($content)) {
                if (isset($product->images)) {
                    $ex_files = json_decode($product->images, true);
                    if (!is_null($ex_files)) {
                        $content = json_encode(array_merge($ex_files, json_decode($content)));
                    }
                }
            }
            $input['images']=$content;
        }
        $product = $this->productRepository->update($input, $id);

        return $this->sendResponse($product->toArray(), 'Product updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/products/{id}",
     *      summary="deleteProduct",
     *      tags={"Product"},
     *      description="Delete Product",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Product",
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
        /** @var Product $product */
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendSuccess('Product deleted successfully');
    }
}
