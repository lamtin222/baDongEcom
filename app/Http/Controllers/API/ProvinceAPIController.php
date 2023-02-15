<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProvinceAPIRequest;
use App\Http\Requests\API\UpdateProvinceAPIRequest;
use App\Models\Province;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProvinceAPIController
 */
class ProvinceAPIController extends AppBaseController
{
    private ProvinceRepository $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepo)
    {
        $this->provinceRepository = $provinceRepo;
    }

    /**
     * Display a listing of the Provinces.
     * GET|HEAD /provinces
     */
    public function index(Request $request): JsonResponse
    {
        $provinces = $this->provinceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($provinces->toArray(), 'Provinces retrieved successfully');
    }
    public function getDistricts(Province $province,Request $request)
    {
        return $this->sendResponse($province->districts->toArray(), 'Districts retrieved successfully');
    }
    /**
     * Store a newly created Province in storage.
     * POST /provinces
     */
    public function store(CreateProvinceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $province = $this->provinceRepository->create($input);

        return $this->sendResponse($province->toArray(), 'Province saved successfully');
    }

    /**
     * Display the specified Province.
     * GET|HEAD /provinces/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Province $province */
        $province = $this->provinceRepository->find($id);

        if (empty($province)) {
            return $this->sendError('Province not found');
        }

        return $this->sendResponse($province->toArray(), 'Province retrieved successfully');
    }

    /**
     * Update the specified Province in storage.
     * PUT/PATCH /provinces/{id}
     */
    public function update($id, UpdateProvinceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Province $province */
        $province = $this->provinceRepository->find($id);

        if (empty($province)) {
            return $this->sendError('Province not found');
        }

        $province = $this->provinceRepository->update($input, $id);

        return $this->sendResponse($province->toArray(), 'Province updated successfully');
    }

    /**
     * Remove the specified Province from storage.
     * DELETE /provinces/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Province $province */
        $province = $this->provinceRepository->find($id);

        if (empty($province)) {
            return $this->sendError('Province not found');
        }

        $province->delete();

        return $this->sendSuccess('Province deleted successfully');
    }
}
