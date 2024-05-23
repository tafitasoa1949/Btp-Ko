<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaiementAPIRequest;
use App\Http\Requests\API\UpdatePaiementAPIRequest;
use App\Models\Paiement;
use App\Repositories\PaiementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PaiementAPIController
 */
class PaiementAPIController extends AppBaseController
{
    private PaiementRepository $paiementRepository;

    public function __construct(PaiementRepository $paiementRepo)
    {
        $this->paiementRepository = $paiementRepo;
    }

    /**
     * Display a listing of the Paiements.
     * GET|HEAD /paiements
     */
    public function index(Request $request): JsonResponse
    {
        $paiements = $this->paiementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($paiements->toArray(), 'Paiements retrieved successfully');
    }

    /**
     * Store a newly created Paiement in storage.
     * POST /paiements
     */
    public function store(CreatePaiementAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $paiement = $this->paiementRepository->create($input);

        return $this->sendResponse($paiement->toArray(), 'Paiement saved successfully');
    }

    /**
     * Display the specified Paiement.
     * GET|HEAD /paiements/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Paiement $paiement */
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            return $this->sendError('Paiement not found');
        }

        return $this->sendResponse($paiement->toArray(), 'Paiement retrieved successfully');
    }

    /**
     * Update the specified Paiement in storage.
     * PUT/PATCH /paiements/{id}
     */
    public function update($id, UpdatePaiementAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Paiement $paiement */
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            return $this->sendError('Paiement not found');
        }

        $paiement = $this->paiementRepository->update($input, $id);

        return $this->sendResponse($paiement->toArray(), 'Paiement updated successfully');
    }

    /**
     * Remove the specified Paiement from storage.
     * DELETE /paiements/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Paiement $paiement */
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            return $this->sendError('Paiement not found');
        }

        $paiement->delete();

        return $this->sendSuccess('Paiement deleted successfully');
    }
}
