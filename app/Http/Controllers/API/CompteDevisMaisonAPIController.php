<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompteDevisMaisonAPIRequest;
use App\Http\Requests\API\UpdateCompteDevisMaisonAPIRequest;
use App\Models\CompteDevisMaison;
use App\Repositories\CompteDevisMaisonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CompteDevisMaisonAPIController
 */
class CompteDevisMaisonAPIController extends AppBaseController
{
    private CompteDevisMaisonRepository $compteDevisMaisonRepository;

    public function __construct(CompteDevisMaisonRepository $compteDevisMaisonRepo)
    {
        $this->compteDevisMaisonRepository = $compteDevisMaisonRepo;
    }

    /**
     * Display a listing of the CompteDevisMaisons.
     * GET|HEAD /compte-devis-maisons
     */
    public function index(Request $request): JsonResponse
    {
        $compteDevisMaisons = $this->compteDevisMaisonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($compteDevisMaisons->toArray(), 'Compte Devis Maisons retrieved successfully');
    }

    /**
     * Store a newly created CompteDevisMaison in storage.
     * POST /compte-devis-maisons
     */
    public function store(CreateCompteDevisMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $compteDevisMaison = $this->compteDevisMaisonRepository->create($input);

        return $this->sendResponse($compteDevisMaison->toArray(), 'Compte Devis Maison saved successfully');
    }

    /**
     * Display the specified CompteDevisMaison.
     * GET|HEAD /compte-devis-maisons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CompteDevisMaison $compteDevisMaison */
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            return $this->sendError('Compte Devis Maison not found');
        }

        return $this->sendResponse($compteDevisMaison->toArray(), 'Compte Devis Maison retrieved successfully');
    }

    /**
     * Update the specified CompteDevisMaison in storage.
     * PUT/PATCH /compte-devis-maisons/{id}
     */
    public function update($id, UpdateCompteDevisMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CompteDevisMaison $compteDevisMaison */
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            return $this->sendError('Compte Devis Maison not found');
        }

        $compteDevisMaison = $this->compteDevisMaisonRepository->update($input, $id);

        return $this->sendResponse($compteDevisMaison->toArray(), 'CompteDevisMaison updated successfully');
    }

    /**
     * Remove the specified CompteDevisMaison from storage.
     * DELETE /compte-devis-maisons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CompteDevisMaison $compteDevisMaison */
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            return $this->sendError('Compte Devis Maison not found');
        }

        $compteDevisMaison->delete();

        return $this->sendSuccess('Compte Devis Maison deleted successfully');
    }
}
