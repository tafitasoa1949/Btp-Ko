<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMaisonAPIRequest;
use App\Http\Requests\API\UpdateMaisonAPIRequest;
use App\Models\Maison;
use App\Repositories\MaisonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class MaisonAPIController
 */
class MaisonAPIController extends AppBaseController
{
    private MaisonRepository $maisonRepository;

    public function __construct(MaisonRepository $maisonRepo)
    {
        $this->maisonRepository = $maisonRepo;
    }

    /**
     * Display a listing of the Maisons.
     * GET|HEAD /maisons
     */
    public function index(Request $request): JsonResponse
    {
        $maisons = $this->maisonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($maisons->toArray(), 'Maisons retrieved successfully');
    }

    /**
     * Store a newly created Maison in storage.
     * POST /maisons
     */
    public function store(CreateMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $maison = $this->maisonRepository->create($input);

        return $this->sendResponse($maison->toArray(), 'Maison saved successfully');
    }

    /**
     * Display the specified Maison.
     * GET|HEAD /maisons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Maison $maison */
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            return $this->sendError('Maison not found');
        }

        return $this->sendResponse($maison->toArray(), 'Maison retrieved successfully');
    }

    /**
     * Update the specified Maison in storage.
     * PUT/PATCH /maisons/{id}
     */
    public function update($id, UpdateMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Maison $maison */
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            return $this->sendError('Maison not found');
        }

        $maison = $this->maisonRepository->update($input, $id);

        return $this->sendResponse($maison->toArray(), 'Maison updated successfully');
    }

    /**
     * Remove the specified Maison from storage.
     * DELETE /maisons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Maison $maison */
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            return $this->sendError('Maison not found');
        }

        $maison->delete();

        return $this->sendSuccess('Maison deleted successfully');
    }
}
