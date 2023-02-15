<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBankAccountAPIRequest;
use App\Http\Requests\API\UpdateBankAccountAPIRequest;
use App\Models\BankAccount;
use App\Repositories\BankAccountRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class BankAccountController
 */

class BankAccountAPIController extends AppBaseController
{
    private BankAccountRepository $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepo)
    {
        $this->bankAccountRepository = $bankAccountRepo;
    }

    /**
     * @OA\Get(
     *      path="/bank-accounts",
     *      summary="getBankAccountList",
     *      tags={"BankAccount"},
     *      description="Get all BankAccounts",
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
     *                  @OA\Items(ref="#/components/schemas/BankAccount")
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
        $bankAccounts = $this->bankAccountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($bankAccounts->toArray(), 'Bank Accounts retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/bank-accounts",
     *      summary="createBankAccount",
     *      tags={"BankAccount"},
     *      description="Create BankAccount",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/BankAccount")
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
     *                  ref="#/components/schemas/BankAccount"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBankAccountAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $bankAccount = $this->bankAccountRepository->create($input);

        return $this->sendResponse($bankAccount->toArray(), 'Bank Account saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/bank-accounts/{id}",
     *      summary="getBankAccountItem",
     *      tags={"BankAccount"},
     *      description="Get BankAccount",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of BankAccount",
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
     *                  ref="#/components/schemas/BankAccount"
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
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        return $this->sendResponse($bankAccount->toArray(), 'Bank Account retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/bank-accounts/{id}",
     *      summary="updateBankAccount",
     *      tags={"BankAccount"},
     *      description="Update BankAccount",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of BankAccount",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/BankAccount")
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
     *                  ref="#/components/schemas/BankAccount"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBankAccountAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        $bankAccount = $this->bankAccountRepository->update($input, $id);

        return $this->sendResponse($bankAccount->toArray(), 'BankAccount updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/bank-accounts/{id}",
     *      summary="deleteBankAccount",
     *      tags={"BankAccount"},
     *      description="Delete BankAccount",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of BankAccount",
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
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository->find($id);

        if (empty($bankAccount)) {
            return $this->sendError('Bank Account not found');
        }

        $bankAccount->delete();

        return $this->sendSuccess('Bank Account deleted successfully');
    }
}
