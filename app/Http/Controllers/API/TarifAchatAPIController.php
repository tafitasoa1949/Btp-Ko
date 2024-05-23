<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTarifAchatAPIRequest;
use App\Http\Requests\API\UpdateTarifAchatAPIRequest;
use App\Models\TarifAchat;
use App\Repositories\TarifAchatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TarifAchatAPIController
 */
class TarifAchatAPIController extends AppBaseController
{
    private TarifAchatRepository $tarifAchatRepository;

    public function __construct(TarifAchatRepository $tarifAchatRepo)
    {
        $this->tarifAchatRepository = $tarifAchatRepo;
    }

    /**
     * Display a listing of the TarifAchats.
     * GET|HEAD /tarif-achats
     */
    public function index(Request $request): JsonResponse
    {
        $tarifAchats = $this->tarifAchatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tarifAchats->toArray(), 'Tarif Achats retrieved successfully');
    }

    /**
     * Store a newly created TarifAchat in storage.
     * POST /tarif-achats
     */
    public function store(CreateTarifAchatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $tarifAchat = $this->tarifAchatRepository->create($input);

        return $this->sendResponse($tarifAchat->toArray(), 'Tarif Achat saved successfully');
    }

    /**
     * Display the specified TarifAchat.
     * GET|HEAD /tarif-achats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var TarifAchat $tarifAchat */
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            return $this->sendError('Tarif Achat not found');
        }

        return $this->sendResponse($tarifAchat->toArray(), 'Tarif Achat retrieved successfully');
    }

    /**
     * Update the specified TarifAchat in storage.
     * PUT/PATCH /tarif-achats/{id}
     */
    public function update($id, UpdateTarifAchatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TarifAchat $tarifAchat */
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            return $this->sendError('Tarif Achat not found');
        }

        $tarifAchat = $this->tarifAchatRepository->update($input, $id);

        return $this->sendResponse($tarifAchat->toArray(), 'TarifAchat updated successfully');
    }

    /**
     * Remove the specified TarifAchat from storage.
     * DELETE /tarif-achats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TarifAchat $tarifAchat */
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            return $this->sendError('Tarif Achat not found');
        }

        $tarifAchat->delete();

        return $this->sendSuccess('Tarif Achat deleted successfully');
    }
}
