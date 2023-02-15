<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCartAPIRequest;
use App\Http\Requests\API\UpdateCartAPIRequest;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\ProductVariant;

use function PHPUnit\Framework\isEmpty;

/**
 * Class CartController
 */

class CartAPIController extends AppBaseController
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepo)
    {
        $this->middleware('auth:sanctum');
        $this->cartRepository = $cartRepo;
    }

    /**
     * @OA\Get(
     *      path="/carts",
     *      summary="getCartList",
     *      tags={"Cart"},
     *      description="Get all Carts",
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
     *                  @OA\Items(ref="#/components/schemas/Cart")
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
        $carts = $this->cartRepository->all(
            ['customer_id'=>auth('sanctum')->id()],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($carts->toArray(), 'Carts of: "'.auth('sanctum')->user()->name.'" retrieved successfully');
    }
    public function fullCart(Request $request)
    {
        $carts = Cart::with(['Product:id,name,images','ProductVariant:id,name,image','Product.productVariants','Store:id,name,slug'])
                        ->where('customer_id', auth('sanctum')->id())

                        ->get()->groupBy('Store');
        $remap = [];
        foreach ($carts as $index => $data) {
            $storeInfo = json_decode($index);
            $remap[] = [
                'id'=>$storeInfo->id,
                'name' => $storeInfo->name,
                'slug'=>$storeInfo->slug,
                "total"=>count($data),
                'cartRows' => $data
            ];
        }

        return $this->sendResponse(array_values($remap), 'Carts of: "'.auth('sanctum')->user()->name.'" retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/carts",
     *      summary="createCart",
     *      tags={"Cart"},
     *      description="Create Cart",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Cart")
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
     *                  ref="#/components/schemas/Cart"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCartAPIRequest $request): JsonResponse
    {
        return $this->addToCart($request);
        // $input = $request->all();

        // $cart = $this->cartRepository->create($input);

        // return $this->sendResponse($cart->toArray(), 'Cart saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/carts/{id}",
     *      summary="getCartItem",
     *      tags={"Cart"},
     *      description="Get Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
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
     *                  ref="#/components/schemas/Cart"
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
        /** @var Cart $cart */
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            return $this->sendError('Cart not found');
        }

        return $this->sendResponse($cart->toArray(), 'Cart retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/carts/{id}",
     *      summary="updateCart",
     *      tags={"Cart"},
     *      description="Update Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Cart")
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
     *                  ref="#/components/schemas/Cart"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCartAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Cart $cart */
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            return $this->sendError('Cart not found');
        }

        $cart = $this->cartRepository->update($input, $id);

        return $this->sendResponse($cart->toArray(), 'Cart updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/carts/{id}",
     *      summary="deleteCart",
     *      tags={"Cart"},
     *      description="Delete Cart",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Cart",
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
        /** @var Cart $cart */
        $cart = $this->cartRepository->find($id);

        if (empty($cart)) {
            return $this->sendError('Cart not found');
        }
        if(auth('sanctum')->id()==$cart->customer_id)
        {$cart->delete();} else {
            $this->sendError("You don't need permission to delete this cart row");
        }

        return $this->sendSuccess('Cart deleted successfully');
    }

    public function addToCart(CreateCartAPIRequest $request)
    {
        $validated = $request->validated();

        $item = Cart::where('variant_id', '=', $request->variant_id)
            ->where('customer_id', '=',auth('sanctum')->user()->id)
            ->first();
        // $productVariant = ProductVariant::find($request->variant_id);
        $productVariant = ProductVariant::find($request->variant_id);

        if ($productVariant==null) {
            return $this->sendError('Variant not found!');
        }
        if (isset($item)) {
            $newqty = (int) $item->qty + $request->qty;
            $item->qty = $newqty;
            $item->price_total = (int) $newqty * $productVariant->price;
            // $item->shipping = $this->getShipping($newqty, $variant);
            $item->updated_at = now();
            $item->save();
            $item->load('Product:id,name,images');
            return $this->sendResponse($item->toArray(), 'Cart updated successfully');
        } else {

            $cart = new Cart;
            $cart->qty = $request->qty;
            $cart->customer_id = auth('sanctum')->user()->id;
            $cart->product_id = $productVariant->Product->id;
            $cart->variant_id = $request->variant_id;
            $cart->ori_price = $productVariant->price;
            $cart->ori_offer_price = $productVariant->price;

            $cart->price_total =  $productVariant->price * $request->qty;
            // $cart->semi_total =  $price->offerprice * $request->qty;
            $cart->store_id = $productVariant->Product?->Category?->store_id;
            // $cart->shipping = $this->getShipping($request->quantity, $productVariant);
            // $cart->created_at = now();
            // $cart->updated_at = now();
            $cart->save();
            $cart->load('Product:id,name,images');
            return $this->sendResponse($cart->toArray(), 'Cart added successfully');

        }

    }

}
