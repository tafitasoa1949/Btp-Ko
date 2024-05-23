<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSsDetailAPIRequest;
use App\Http\Requests\API\UpdateSsDetailAPIRequest;
use App\Models\SsDetail;
use App\Repositories\SsDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SsDetailAPIController
 */
class SsDetailAPIController extends AppBaseController
{
    private SsDetailRepository $ssDetailRepository;

    public function __construct(SsDetailRepository $ssDetailRepo)
    {
        $this->ssDetailRepository = $ssDetailRepo;
    }

    /**
     * Display a listing of the SsDetails.
     * GET|HEAD /ss-details
     */
    public function index(Request $request): JsonResponse
    {
        $ssDetails = $this->ssDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($ssDetails->toArray(), 'Ss Details retrieved successfully');
    }

    /**
     * Store a newly created SsDetail in storage.
     * POST /ss-details
     */
    public function store(CreateSsDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $ssDetail = $this->ssDetailRepository->create($input);

        return $this->sendResponse($ssDetail->toArray(), 'Ss Detail saved successfully');
    }

    /**
     * Display the specified SsDetail.
     * GET|HEAD /ss-details/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var SsDetail $ssDetail */
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            return $this->sendError('Ss Detail not found');
        }

        return $this->sendResponse($ssDetail->toArray(), 'Ss Detail retrieved successfully');
    }

    /**
     * Update the specified SsDetail in storage.
     * PUT/PATCH /ss-details/{id}
     */
    public function update($id, UpdateSsDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var SsDetail $ssDetail */
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            return $this->sendError('Ss Detail not found');
        }

        $ssDetail = $this->ssDetailRepository->update($input, $id);

        return $this->sendResponse($ssDetail->toArray(), 'SsDetail updated successfully');
    }

    /**
     * Remove the specified SsDetail from storage.
     * DELETE /ss-details/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var SsDetail $ssDetail */
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            return $this->sendError('Ss Detail not found');
        }

        $ssDetail->delete();

        return $this->sendSuccess('Ss Detail deleted successfully');
    }
}
