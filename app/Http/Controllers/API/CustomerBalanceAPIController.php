<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCustomerBalanceAPIRequest;
use App\Http\Requests\API\UpdateCustomerBalanceAPIRequest;
use App\Models\CustomerBalance;
use App\Repositories\CustomerBalanceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CustomerBalanceController
 */

class CustomerBalanceAPIController extends AppBaseController
{
    private CustomerBalanceRepository $customerBalanceRepository;

    public function __construct(CustomerBalanceRepository $customerBalanceRepo)
    {
        $this->customerBalanceRepository = $customerBalanceRepo;
    }

    /**
     * @OA\Get(
     *      path="/customer-balances",
     *      summary="getCustomerBalanceList",
     *      tags={"CustomerBalance"},
     *      description="Get all CustomerBalances",
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
     *                  @OA\Items(ref="#/components/schemas/CustomerBalance")
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
        $customerBalances = $this->customerBalanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customerBalances->toArray(), 'Customer Balances retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/customer-balances",
     *      summary="createCustomerBalance",
     *      tags={"CustomerBalance"},
     *      description="Create CustomerBalance",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerBalance")
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
     *                  ref="#/components/schemas/CustomerBalance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCustomerBalanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $customerBalance = $this->customerBalanceRepository->create($input);

        return $this->sendResponse($customerBalance->toArray(), 'Customer Balance saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/customer-balances/{id}",
     *      summary="getCustomerBalanceItem",
     *      tags={"CustomerBalance"},
     *      description="Get CustomerBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerBalance",
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
     *                  ref="#/components/schemas/CustomerBalance"
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
        /** @var CustomerBalance $customerBalance */
        $customerBalance = $this->customerBalanceRepository->find($id);

        if (empty($customerBalance)) {
            return $this->sendError('Customer Balance not found');
        }

        return $this->sendResponse($customerBalance->toArray(), 'Customer Balance retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/customer-balances/{id}",
     *      summary="updateCustomerBalance",
     *      tags={"CustomerBalance"},
     *      description="Update CustomerBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerBalance",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/CustomerBalance")
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
     *                  ref="#/components/schemas/CustomerBalance"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCustomerBalanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CustomerBalance $customerBalance */
        $customerBalance = $this->customerBalanceRepository->find($id);

        if (empty($customerBalance)) {
            return $this->sendError('Customer Balance not found');
        }

        $customerBalance = $this->customerBalanceRepository->update($input, $id);

        return $this->sendResponse($customerBalance->toArray(), 'CustomerBalance updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/customer-balances/{id}",
     *      summary="deleteCustomerBalance",
     *      tags={"CustomerBalance"},
     *      description="Delete CustomerBalance",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of CustomerBalance",
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
        /** @var CustomerBalance $customerBalance */
        $customerBalance = $this->customerBalanceRepository->find($id);

        if (empty($customerBalance)) {
            return $this->sendError('Customer Balance not found');
        }

        $customerBalance->delete();

        return $this->sendSuccess('Customer Balance deleted successfully');
    }
}
