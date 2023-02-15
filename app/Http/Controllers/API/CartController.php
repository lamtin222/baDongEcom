<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\ProductVariant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends AppBaseController
{
    protected $cart;
    public function __construct()
    {
       $this->middleware(['auth:sanctum']);
       if(auth('sanctum')->check()) {
            $customer = auth('sanctum')->user();
            $this->cart = Cart::instance($customer)->restore($customer->email);
            if (!$this->cart) {
                $this->cart = Cart::instance($customer);
            }
        }
    }
    public function __destruct()
    {
        if(auth('sanctum')->check()) {
            $this->cart->store(auth('sanctum')->user()->email);
        }
    }
    /**
     * @OA\Get(
     *      path="/cart",
     *      summary="Initial or restore cart for customer",
     *      tags={"Test Cart glouderman"},
     *      description="Get Customer's cart. Initial (or restore) cart for customer by using there email",

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
     *                    @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getCart(Request $request)
    {
        $this->cart->store($request->user()->email);
       return $this->cart->content();
    }
    /**
     * @OA\Post(
     *      path="/cart/add",
     *      summary="Add an item to cart",
     *      tags={"Test Cart glouderman"},
     *      description="Add an item to cart by post the item variant id",

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
     *                    @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function addCart(Request $request)
    {
        $variant=ProductVariant::findOrFail($request->id);
        $this->cart->add($variant)->associate($variant);
       return $this->cart->content();
    }
    /**
     * @OA\Post(
     *      path="/cart/edit",
     *      summary="Edit an item of the cart",
     *      tags={"Test Cart glouderman"},
     *      description="Edit an item to cart by post the rowId and qty",

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
     *                    @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updateCart(Request $request)
    {
        $this->cart->update($request->rowId,$request->qty);
       return $this->cart->content();
    }
    /**
     * @OA\Post(
     *      path="/cart/remove",
     *      summary="Remove an item to cart",
     *      tags={"Test Cart glouderman"},
     *      description="Remove an item from cart by post the rowId",

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
     *                    @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function removeCart(Request $request)
    {
        $this->cart->remove($request->rowId);
       return $this->cart->content();
    }
    /**
     * @OA\Post(
     *      path="/cart/clear",
     *      summary="Clear cart",
     *      tags={"Test Cart glouderman"},
     *      description="Empty the cart",

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
     *                    @OA\Items()
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function clearCart(Request $request)
    {
        Cart::erase($request->user()->email);
    }


}
