<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDetailTravailAPIRequest;
use App\Http\Requests\API\UpdateDetailTravailAPIRequest;
use App\Models\DetailTravail;
use App\Repositories\DetailTravailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DetailTravailAPIController
 */
class DetailTravailAPIController extends AppBaseController
{
    private DetailTravailRepository $detailTravailRepository;

    public function __construct(DetailTravailRepository $detailTravailRepo)
    {
        $this->detailTravailRepository = $detailTravailRepo;
    }

    /**
     * Display a listing of the DetailTravails.
     * GET|HEAD /detail-travails
     */
    public function index(Request $request): JsonResponse
    {
        $detailTravails = $this->detailTravailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($detailTravails->toArray(), 'Detail Travails retrieved successfully');
    }

    /**
     * Store a newly created DetailTravail in storage.
     * POST /detail-travails
     */
    public function store(CreateDetailTravailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $detailTravail = $this->detailTravailRepository->create($input);

        return $this->sendResponse($detailTravail->toArray(), 'Detail Travail saved successfully');
    }

    /**
     * Display the specified DetailTravail.
     * GET|HEAD /detail-travails/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DetailTravail $detailTravail */
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            return $this->sendError('Detail Travail not found');
        }

        return $this->sendResponse($detailTravail->toArray(), 'Detail Travail retrieved successfully');
    }

    /**
     * Update the specified DetailTravail in storage.
     * PUT/PATCH /detail-travails/{id}
     */
    public function update($id, UpdateDetailTravailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DetailTravail $detailTravail */
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            return $this->sendError('Detail Travail not found');
        }

        $detailTravail = $this->detailTravailRepository->update($input, $id);

        return $this->sendResponse($detailTravail->toArray(), 'DetailTravail updated successfully');
    }

    /**
     * Remove the specified DetailTravail from storage.
     * DELETE /detail-travails/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DetailTravail $detailTravail */
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            return $this->sendError('Detail Travail not found');
        }

        $detailTravail->delete();

        return $this->sendSuccess('Detail Travail deleted successfully');
    }
}
