<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompteAPIRequest;
use App\Http\Requests\API\UpdateCompteAPIRequest;
use App\Models\Compte;
use App\Repositories\CompteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CompteAPIController
 */
class CompteAPIController extends AppBaseController
{
    private CompteRepository $compteRepository;

    public function __construct(CompteRepository $compteRepo)
    {
        $this->compteRepository = $compteRepo;
    }

    /**
     * Display a listing of the Comptes.
     * GET|HEAD /comptes
     */
    public function index(Request $request): JsonResponse
    {
        $comptes = $this->compteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($comptes->toArray(), 'Comptes retrieved successfully');
    }

    /**
     * Store a newly created Compte in storage.
     * POST /comptes
     */
    public function store(CreateCompteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $compte = $this->compteRepository->create($input);

        return $this->sendResponse($compte->toArray(), 'Compte saved successfully');
    }

    /**
     * Display the specified Compte.
     * GET|HEAD /comptes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Compte $compte */
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            return $this->sendError('Compte not found');
        }

        return $this->sendResponse($compte->toArray(), 'Compte retrieved successfully');
    }

    /**
     * Update the specified Compte in storage.
     * PUT/PATCH /comptes/{id}
     */
    public function update($id, UpdateCompteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Compte $compte */
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            return $this->sendError('Compte not found');
        }

        $compte = $this->compteRepository->update($input, $id);

        return $this->sendResponse($compte->toArray(), 'Compte updated successfully');
    }

    /**
     * Remove the specified Compte from storage.
     * DELETE /comptes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Compte $compte */
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            return $this->sendError('Compte not found');
        }

        $compte->delete();

        return $this->sendSuccess('Compte deleted successfully');
    }
}
