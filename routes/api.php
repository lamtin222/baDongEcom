<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\ProductVariantAPIController;
use App\Http\Controllers\API\CustomerAPIController;
use App\Http\Controllers\API\IndexApiController;
use App\Http\Controllers\API\StoreAPIController;
use App\Http\Controllers\API\StoreCategoryAPIController;
use App\Http\Controllers\API\TestApiController;
use App\Http\Controllers\AppBaseController;
use App\Models\Customer;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test',[TestApiController::class,'index']);

Route::post('remove-media',[AppBaseController::class,'remove_media']);
Route::post('setting',fn()=>[
    'title'=>setting('site.title'),
    'description'=>setting('site.description'),
    'logo'=>setting('site.logo')

]);
Route::post('login',[AuthController::class,'login'])->name('login');

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('customer-test',function(Request $request){
        return $request->user();
    });

});

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::prefix('cart')->group(function(){
        Route::get('/',[CartController::class,'getCart']);

        Route::post('/add',[CartController::class,'addCart']);

        Route::post('/edit',[CartController::class,'updateCart']);

        Route::post('/delete',[CartController::class,'removeCart']);

        Route::post('/clear',[CartController::class,'clearCart']);
    });
});




    Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class)
        ->except(['create', 'edit']);
    Route::resource('provinces', App\Http\Controllers\API\ProvinceAPIController::class)
        ->except(['create', 'edit']);
    Route::get('provinces/{province}/districts', [App\Http\Controllers\API\ProvinceAPIController::class,'getDistricts']) ;

    Route::resource('districts', App\Http\Controllers\API\DistrictAPIController::class)
        ->except(['create', 'edit']);
    Route::resource('wards', App\Http\Controllers\API\WardAPIController::class)
        ->except(['create', 'edit']);
    // -----------------------------------------------------------------
    Route::resource('customers', App\Http\Controllers\API\CustomerAPIController::class)
        ->except(['create', 'edit']);
    Route::get('customers/{customer}/store',[StoreAPIController::class,'getStoreByCustomer']);

    Route::resource('customer-balances', App\Http\Controllers\API\CustomerBalanceAPIController::class)
        ->except(['create', 'edit']);




    Route::resource('bank-accounts', App\Http\Controllers\API\BankAccountAPIController::class)
        ->except(['create', 'edit']);




    Route::get('product/{slug?}', [App\Http\Controllers\API\ProductAPIController::class,'showBySlug']);
    Route::get('product/{slug?}/related-products', [App\Http\Controllers\API\ProductAPIController::class,'relatedProducts']);
    Route::resource('products', App\Http\Controllers\API\ProductAPIController::class)
        ->except(['create', 'edit']);





    Route::get('product/{product}/variants',[ProductVariantAPIController::class,'getVariant']);
    Route::resource('product-variants', App\Http\Controllers\API\ProductVariantAPIController::class)
        ->except(['create', 'edit']);

    #region store routes
    Route::resource('stores', App\Http\Controllers\API\StoreAPIController::class)
        ->except(['create', 'edit']);
    Route::get('store/{store}/customers',[CustomerAPIController::class,'getCustomerByStore']);
    Route::get('store/{store}/categories',[StoreCategoryAPIController::class,'getCategories']);
    Route::get('store/{store}/products',[ProductAPIController::class,'getProductsByStore']);


    Route::resource('store-categories', App\Http\Controllers\API\StoreCategoryAPIController::class)
        ->except(['create', 'edit']);
    Route::get('store-categories/{storeCategory}/products',[ProductAPIController::class,'getProductsByCategory']);
    Route::get('store-category/{slug}/products',[ProductAPIController::class,'getProductsByCategorySlug']);
    Route::resource('store-category-banners', App\Http\Controllers\API\StoreCategoryBannerAPIController::class)
        ->except(['create', 'edit']);
    Route::resource('store-decors', App\Http\Controllers\API\StoreDecorAPIController::class)
        ->except(['create', 'edit']);
    Route::resource('addresses', App\Http\Controllers\API\AddressAPIController::class)
        ->except(['create', 'edit']);
    Route::resource('store-balances', App\Http\Controllers\API\StoreBalanceAPIController::class)
        ->except(['create', 'edit']);
    #endregion









Route::resource('product-rates', App\Http\Controllers\API\ProductRateAPIController::class)
    ->except(['create', 'edit']);
    Route::get('grand-category/{slug?}', [App\Http\Controllers\API\GrandCategoryAPIController::class, 'showBySlug']);
    Route::get('grand-category/{slug}/products', [App\Http\Controllers\API\GrandCategoryAPIController::class, 'getProduct']);
    // Route::get('grand-category/{id}/products', [App\Http\Controllers\API\GrandCategoryAPIController::class, 'getProduct']);
Route::resource('grand-categories', App\Http\Controllers\API\GrandCategoryAPIController::class)
    ->except(['create', 'edit']);

// --------------------index-------------------
Route::get('index/hot-product', [IndexApiController::class, 'hotProduct']);
Route::get('index/grand-categories/{grandCategory}/products', [IndexApiController::class, 'getProdutByGrandCategory']);

Route::post('cart/add', [App\Http\Controllers\API\CartAPIController::class, 'addToCart'])->middleware('auth:sanctum');
Route::post('full-cart', [App\Http\Controllers\API\CartAPIController::class, 'fullCart'])->middleware('auth:sanctum');

Route::resource('carts', App\Http\Controllers\API\CartAPIController::class)
    ->except(['create', 'edit']);
