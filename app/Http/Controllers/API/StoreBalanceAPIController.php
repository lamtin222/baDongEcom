<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreBalanceAPIRequest;
use App\Http\Requests\API\UpdateStoreBalanceAPIRequest;
use App\Models\StoreBalance;
use App\Repositories\StoreBalanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class StoreBalanceController
 */

class StoreBalanceAPIController extends AppBaseController
{
    private StoreBalanceRepository $storeBalanceRepository;

    public function __construct(StoreBalanceRepository $storeBalanceRepo)
    {
        $this->storeBalanceRepository = $storeBalanceRepo;
    }

    /**
     * @OA\Get(
     *      path="/store-balances",
     *      summary="getStoreBalanceList",
     *      tags={"StoreBalance"},
     *      description="Get all StoreBalances",
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
     *                  @OA\Items(ref="#/components/schemas/StoreBalance")
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
        $storeBalances = $this->storeBalanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($storeBalances->toArray(), 'Store Balances retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/store-balances",
     *      summary="createStoreBalance",
     *      tags={"StoreBalance"},
     *      description="Create StoreBalance",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreBalance")
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
     *                  ref="#/components/schemas/StoreBalance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStoreBalanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $storeBalance = $this->storeBalanceRepository->create($input);

        return $this->sendResponse($storeBalance->toArray(), 'Store Balance saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/store-balances/{id}",
     *      summary="getStoreBalanceItem",
     *      tags={"StoreBalance"},
     *      description="Get StoreBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreBalance",
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
     *                  ref="#/components/schemas/StoreBalance"
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
        /** @var StoreBalance $storeBalance */
        $storeBalance = $this->storeBalanceRepository->find($id);

        if (empty($storeBalance)) {
            return $this->sendError('Store Balance not found');
        }

        return $this->sendResponse($storeBalance->toArray(), 'Store Balance retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/store-balances/{id}",
     *      summary="updateStoreBalance",
     *      tags={"StoreBalance"},
     *      description="Update StoreBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreBalance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/StoreBalance")
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
     *                  ref="#/components/schemas/StoreBalance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStoreBalanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var StoreBalance $storeBalance */
        $storeBalance = $this->storeBalanceRepository->find($id);

        if (empty($storeBalance)) {
            return $this->sendError('Store Balance not found');
        }

        $storeBalance = $this->storeBalanceRepository->update($input, $id);

        return $this->sendResponse($storeBalance->toArray(), 'StoreBalance updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/store-balances/{id}",
     *      summary="deleteStoreBalance",
     *      tags={"StoreBalance"},
     *      description="Delete StoreBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of StoreBalance",
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
        /** @var StoreBalance $storeBalance */
        $storeBalance = $this->storeBalanceRepository->find($id);

        if (empty($storeBalance)) {
            return $this->sendError('Store Balance not found');
        }

        $storeBalance->delete();

        return $this->sendSuccess('Store Balance deleted successfully');
    }
}
