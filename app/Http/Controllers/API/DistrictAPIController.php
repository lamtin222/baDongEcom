<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDistrictAPIRequest;
use App\Http\Requests\API\UpdateDistrictAPIRequest;
use App\Models\District;
use App\Repositories\DistrictRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DistrictAPIController
 */
class DistrictAPIController extends AppBaseController
{
    private DistrictRepository $districtRepository;

    public function __construct(DistrictRepository $districtRepo)
    {
        $this->districtRepository = $districtRepo;
    }

    /**
     * Display a listing of the Districts.
     * GET|HEAD /districts
     */
    public function index(Request $request): JsonResponse
    {
        $districts = $this->districtRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully');
    }

    /**
     * Store a newly created District in storage.
     * POST /districts
     */
    public function store(CreateDistrictAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $district = $this->districtRepository->create($input);

        return $this->sendResponse($district->toArray(), 'District saved successfully');
    }

    /**
     * Display the specified District.
     * GET|HEAD /districts/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var District $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        return $this->sendResponse($district->toArray(), 'District retrieved successfully');
    }

    /**
     * Update the specified District in storage.
     * PUT/PATCH /districts/{id}
     */
    public function update($id, UpdateDistrictAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var District $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district = $this->districtRepository->update($input, $id);

        return $this->sendResponse($district->toArray(), 'District updated successfully');
    }

    /**
     * Remove the specified District from storage.
     * DELETE /districts/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var District $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district->delete();

        return $this->sendSuccess('District deleted successfully');
    }
}
