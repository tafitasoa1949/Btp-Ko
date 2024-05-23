<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFinitionAPIRequest;
use App\Http\Requests\API\UpdateFinitionAPIRequest;
use App\Models\Finition;
use App\Repositories\FinitionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class FinitionAPIController
 */
class FinitionAPIController extends AppBaseController
{
    private FinitionRepository $finitionRepository;

    public function __construct(FinitionRepository $finitionRepo)
    {
        $this->finitionRepository = $finitionRepo;
    }

    /**
     * Display a listing of the Finitions.
     * GET|HEAD /finitions
     */
    public function index(Request $request): JsonResponse
    {
        $finitions = $this->finitionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($finitions->toArray(), 'Finitions retrieved successfully');
    }

    /**
     * Store a newly created Finition in storage.
     * POST /finitions
     */
    public function store(CreateFinitionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $finition = $this->finitionRepository->create($input);

        return $this->sendResponse($finition->toArray(), 'Finition saved successfully');
    }

    /**
     * Display the specified Finition.
     * GET|HEAD /finitions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        return $this->sendResponse($finition->toArray(), 'Finition retrieved successfully');
    }

    /**
     * Update the specified Finition in storage.
     * PUT/PATCH /finitions/{id}
     */
    public function update($id, UpdateFinitionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        $finition = $this->finitionRepository->update($input, $id);

        return $this->sendResponse($finition->toArray(), 'Finition updated successfully');
    }

    /**
     * Remove the specified Finition from storage.
     * DELETE /finitions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        $finition->delete();

        return $this->sendSuccess('Finition deleted successfully');
    }
}
