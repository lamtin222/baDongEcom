<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWardAPIRequest;
use App\Http\Requests\API\UpdateWardAPIRequest;
use App\Models\Ward;
use App\Repositories\WardRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class WardAPIController
 */
class WardAPIController extends AppBaseController
{
    private WardRepository $wardRepository;

    public function __construct(WardRepository $wardRepo)
    {
        $this->wardRepository = $wardRepo;
    }

    /**
     * Display a listing of the Wards.
     * GET|HEAD /wards
     */
    public function index(Request $request): JsonResponse
    {
        $wards = $this->wardRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($wards->toArray(), 'Wards retrieved successfully');
    }

    /**
     * Store a newly created Ward in storage.
     * POST /wards
     */
    public function store(CreateWardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $ward = $this->wardRepository->create($input);

        return $this->sendResponse($ward->toArray(), 'Ward saved successfully');
    }

    /**
     * Display the specified Ward.
     * GET|HEAD /wards/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Ward $ward */
        $ward = $this->wardRepository->find($id);

        if (empty($ward)) {
            return $this->sendError('Ward not found');
        }

        return $this->sendResponse($ward->toArray(), 'Ward retrieved successfully');
    }

    /**
     * Update the specified Ward in storage.
     * PUT/PATCH /wards/{id}
     */
    public function update($id, UpdateWardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Ward $ward */
        $ward = $this->wardRepository->find($id);

        if (empty($ward)) {
            return $this->sendError('Ward not found');
        }

        $ward = $this->wardRepository->update($input, $id);

        return $this->sendResponse($ward->toArray(), 'Ward updated successfully');
    }

    /**
     * Remove the specified Ward from storage.
     * DELETE /wards/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Ward $ward */
        $ward = $this->wardRepository->find($id);

        if (empty($ward)) {
            return $this->sendError('Ward not found');
        }

        $ward->delete();

        return $this->sendSuccess('Ward deleted successfully');
    }
}
