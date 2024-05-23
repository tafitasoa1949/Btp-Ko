<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUniteAPIRequest;
use App\Http\Requests\API\UpdateUniteAPIRequest;
use App\Models\Unite;
use App\Repositories\UniteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class UniteAPIController
 */
class UniteAPIController extends AppBaseController
{
    private UniteRepository $uniteRepository;

    public function __construct(UniteRepository $uniteRepo)
    {
        $this->uniteRepository = $uniteRepo;
    }

    /**
     * Display a listing of the Unites.
     * GET|HEAD /unites
     */
    public function index(Request $request): JsonResponse
    {
        $unites = $this->uniteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($unites->toArray(), 'Unites retrieved successfully');
    }

    /**
     * Store a newly created Unite in storage.
     * POST /unites
     */
    public function store(CreateUniteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $unite = $this->uniteRepository->create($input);

        return $this->sendResponse($unite->toArray(), 'Unite saved successfully');
    }

    /**
     * Display the specified Unite.
     * GET|HEAD /unites/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Unite $unite */
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            return $this->sendError('Unite not found');
        }

        return $this->sendResponse($unite->toArray(), 'Unite retrieved successfully');
    }

    /**
     * Update the specified Unite in storage.
     * PUT/PATCH /unites/{id}
     */
    public function update($id, UpdateUniteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Unite $unite */
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            return $this->sendError('Unite not found');
        }

        $unite = $this->uniteRepository->update($input, $id);

        return $this->sendResponse($unite->toArray(), 'Unite updated successfully');
    }

    /**
     * Remove the specified Unite from storage.
     * DELETE /unites/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Unite $unite */
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            return $this->sendError('Unite not found');
        }

        $unite->delete();

        return $this->sendSuccess('Unite deleted successfully');
    }
}
