<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;


class OrderController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function makeOrder()
    {
        $customer = auth('sanctum')->user();
        $cart = Cart::instance($customer)->restore($customer->email);
        if(!$cart->count()){
            $this->sendError('Your Shopping Cart Are Empty!');
        }
        else{
            //create order
        }
    }
}
