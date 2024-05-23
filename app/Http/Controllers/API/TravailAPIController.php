<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTravailAPIRequest;
use App\Http\Requests\API\UpdateTravailAPIRequest;
use App\Models\Travail;
use App\Repositories\TravailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TravailAPIController
 */
class TravailAPIController extends AppBaseController
{
    private TravailRepository $travailRepository;

    public function __construct(TravailRepository $travailRepo)
    {
        $this->travailRepository = $travailRepo;
    }

    /**
     * Display a listing of the Travails.
     * GET|HEAD /travails
     */
    public function index(Request $request): JsonResponse
    {
        $travails = $this->travailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($travails->toArray(), 'Travails retrieved successfully');
    }

    /**
     * Store a newly created Travail in storage.
     * POST /travails
     */
    public function store(CreateTravailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $travail = $this->travailRepository->create($input);

        return $this->sendResponse($travail->toArray(), 'Travail saved successfully');
    }

    /**
     * Display the specified Travail.
     * GET|HEAD /travails/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Travail $travail */
        $travail = $this->travailRepository->find($id);

        if (empty($travail)) {
            return $this->sendError('Travail not found');
        }

        return $this->sendResponse($travail->toArray(), 'Travail retrieved successfully');
    }

    /**
     * Update the specified Travail in storage.
     * PUT/PATCH /travails/{id}
     */
    public function update($id, UpdateTravailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Travail $travail */
        $travail = $this->travailRepository->find($id);

        if (empty($travail)) {
            return $this->sendError('Travail not found');
        }

        $travail = $this->travailRepository->update($input, $id);

        return $this->sendResponse($travail->toArray(), 'Travail updated successfully');
    }

    /**
     * Remove the specified Travail from storage.
     * DELETE /travails/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Travail $travail */
        $travail = $this->travailRepository->find($id);

        if (empty($travail)) {
            return $this->sendError('Travail not found');
        }

        $travail->delete();

        return $this->sendSuccess('Travail deleted successfully');
    }
}
