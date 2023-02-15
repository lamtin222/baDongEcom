<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\GrandCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexApiController extends AppBaseController
{
   public function hotProduct(Request $request)
   {
        $limit = 8;
        if ($request->has('limit')) {
            $limit = $request->limit;
        }
        $feature=Product::whereHas('productVariants')->latest()->limit($limit)->get();
        $hotToday = Product::whereHas('productVariants')->latest('updated_at')->limit($limit)->get();
        $forYou = Product::whereHas('productVariants')->inRandomOrder()->limit($limit)->get();
        return $this->sendResponse([
            "feature"=>$feature->load('productVariants')->toArray(),
            "hotToday"=>$hotToday->load('productVariants')->toArray(),
            'forYou'=>$forYou->load('productVariants')->toArray(),
        ],"Product hot today retreived success");
   }
   public function getProdutByGrandCategory(GrandCategory $grandCategory,Request $request)
   {
        $limit = 8;
        if ($request->has('limit')) {
            $limit = $request->limit;
        }
        $products= $grandCategory->products()->limit($limit)->get();
        return $this->sendResponse($products->toArray(), 'Retreived products success');
   }
}
