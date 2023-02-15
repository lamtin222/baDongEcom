<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {

       $product=Product::find(1);
       $product->Rate()->create(
        ['rate' => [
            "1"=>"0",
            "2"=>"0",
            "3"=>"0",
            "4"=>"0",
            "5"=>"0",
        ],
        'avg_rate' => 0,
        'total' => 0]);
        return response()->json("ok", 200);;
    }


}
