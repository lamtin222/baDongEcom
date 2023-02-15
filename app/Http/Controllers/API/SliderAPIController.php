<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSliderAPIRequest;
use App\Http\Requests\API\UpdateSliderAPIRequest;
use App\Models\Slider;
use App\Repositories\SliderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SliderAPIController
 */
class SliderAPIController extends AppBaseController
{
    private SliderRepository $sliderRepository;

    protected $modelName='slider';

    public function __construct(SliderRepository $sliderRepo)
    {
        $this->sliderRepository = $sliderRepo;
    }

    /**
     * Display a listing of the Sliders.
     * GET|HEAD /sliders
     */
    public function index(Request $request): JsonResponse
    {
        $sliders = $this->sliderRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sliders->toArray(), 'Sliders retrieved successfully');
    }

    /**
     * Store a newly created Slider in storage.
     * POST /sliders
     */
    public function store(CreateSliderAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        if($request->hasFile('image')) {
            $input['image'] = $this->handleUploadImage($request, 'image');
        }
        $slider = $this->sliderRepository->create($input);

        return $this->sendResponse($slider->toArray(), 'Slider saved successfully');
    }

    /**
     * Display the specified Slider.
     * GET|HEAD /sliders/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }

        return $this->sendResponse($slider->toArray(), 'Slider retrieved successfully');
    }

    /**
     * Update the specified Slider in storage.
     * PUT/PATCH /sliders/{id}
     */
    public function update($id, UpdateSliderAPIRequest $request): JsonResponse
    {
        $input = $request->all();


        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }
        if($request->hasFile('image')) {
            $this->removeFile($slider->image);
            $input['image'] = $this->handleUploadImage($request, 'image');
        }

        $slider = $this->sliderRepository->update($input, $id);

        return $this->sendResponse($slider->toArray(), 'Slider updated successfully');
    }

    /**
     * Remove the specified Slider from storage.
     * DELETE /sliders/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);
        $this->removeFile($slider->image);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }

        $slider->delete();

        return $this->sendSuccess('Slider deleted successfully');
    }
}
