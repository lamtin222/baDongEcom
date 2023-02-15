<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreAPIRequest;
use App\Http\Requests\API\UpdateStoreAPIRequest;
use App\Models\Store;
use App\Models\Customer;
use App\Repositories\StoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;

/**
 * Class StoreController
 */

class StoreAPIController extends AppBaseController
{
    private StoreRepository $storeRepository;

    public function __construct(StoreRepository $storeRepo)
    {
        $this->storeRepository = $storeRepo;
        $this->middleware('auth:sanctum')->only(['store','show','update','destroy']);
    }

    /**
     * @OA\Get(
     *      path="/stores",
     *      summary="getStoreList",
     *      tags={"Store"},
     *      description="Get all Stores",
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
     *                  @OA\Items(ref="#/components/schemas/Store")
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
        $stores = $this->storeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($stores->toArray(), 'Stores retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/stores",
     *      summary="createStore",
     *      tags={"Store"},
     *      description="Create Store",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Store")
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
     *                  ref="#/components/schemas/Store"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStoreAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->middleware(['auth:sanctum']);
        $customer=auth('sanctum')->user();
        //check if user had created or manage a store
        if($customer->store_id){
            return $this->sendError("customer already had a store");
        }
        else
        $input['owner_id']=$customer->id;
        $store = $this->storeRepository->create($input);
        $customer->update(['store_id'=>$store->id]);


        return $this->sendResponse($store->toArray(), 'Store saved successfully');
    }

    /**
     * @OA\Get(
     *      path="customers/{customer}/store",
     *      summary="getStoreByCustomer",
     *      tags={"Store"},
     *      description="Get Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
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
     *                  ref="#/components/schemas/Store"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getStoreByCustomer(Customer $customer)
    {
        /** @var Store $store */
        $stores = $customer->Store;

        if (empty($stores)) {
            return $this->sendError('Store not found');
        }


        return $this->sendResponse($stores->first()->toArray(), 'Store retrieved successfully');
    }
    /**
     * @OA\Get(
     *      path="/stores/{id}",
     *      summary="getStoreItem",
     *      tags={"Store"},
     *      description="Get Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
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
     *                  ref="#/components/schemas/Store"
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
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        return $this->sendResponse($store->toArray(), 'Store retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/stores/{id}",
     *      summary="updateStore",
     *      tags={"Store"},
     *      description="Update Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Store")
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
     *                  ref="#/components/schemas/Store"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStoreAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->middleware(['auth:sanctum']);
        $customer=auth('sanctum')->user();
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }
        //check if user had created or manage a store
        if(!DB::table('store_customers')->where('customer_id',$customer->id)
                                        ->where('store_id',$id)
                                        ->where('is_default',1)
                                        ->exists()){
            return $this->sendError("customer doesn't have permission to update store's information");
        }


        $store = $this->storeRepository->update($input, $id);

        return $this->sendResponse($store->toArray(), 'Store updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/stores/{id}",
     *      summary="deleteStore",
     *      tags={"Store"},
     *      description="Delete Store",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Store",
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
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $store->delete();

        return $this->sendSuccess('Store deleted successfully');
    }
}
