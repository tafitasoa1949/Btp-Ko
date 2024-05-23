<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDevisMaisonAPIRequest;
use App\Http\Requests\API\UpdateDevisMaisonAPIRequest;
use App\Models\DevisMaison;
use App\Repositories\DevisMaisonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DevisMaisonAPIController
 */
class DevisMaisonAPIController extends AppBaseController
{
    private DevisMaisonRepository $devisMaisonRepository;

    public function __construct(DevisMaisonRepository $devisMaisonRepo)
    {
        $this->devisMaisonRepository = $devisMaisonRepo;
    }

    /**
     * Display a listing of the DevisMaisons.
     * GET|HEAD /devis-maisons
     */
    public function index(Request $request): JsonResponse
    {
        $devisMaisons = $this->devisMaisonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($devisMaisons->toArray(), 'Devis Maisons retrieved successfully');
    }

    /**
     * Store a newly created DevisMaison in storage.
     * POST /devis-maisons
     */
    public function store(CreateDevisMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $devisMaison = $this->devisMaisonRepository->create($input);

        return $this->sendResponse($devisMaison->toArray(), 'Devis Maison saved successfully');
    }

    /**
     * Display the specified DevisMaison.
     * GET|HEAD /devis-maisons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DevisMaison $devisMaison */
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            return $this->sendError('Devis Maison not found');
        }

        return $this->sendResponse($devisMaison->toArray(), 'Devis Maison retrieved successfully');
    }

    /**
     * Update the specified DevisMaison in storage.
     * PUT/PATCH /devis-maisons/{id}
     */
    public function update($id, UpdateDevisMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DevisMaison $devisMaison */
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            return $this->sendError('Devis Maison not found');
        }

        $devisMaison = $this->devisMaisonRepository->update($input, $id);

        return $this->sendResponse($devisMaison->toArray(), 'DevisMaison updated successfully');
    }

    /**
     * Remove the specified DevisMaison from storage.
     * DELETE /devis-maisons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DevisMaison $devisMaison */
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            return $this->sendError('Devis Maison not found');
        }

        $devisMaison->delete();

        return $this->sendSuccess('Devis Maison deleted successfully');
    }
}
