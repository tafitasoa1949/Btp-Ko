<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDetailDevisAPIRequest;
use App\Http\Requests\API\UpdateDetailDevisAPIRequest;
use App\Models\DetailDevis;
use App\Repositories\DetailDevisRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DetailDevisAPIController
 */
class DetailDevisAPIController extends AppBaseController
{
    private DetailDevisRepository $detailDevisRepository;

    public function __construct(DetailDevisRepository $detailDevisRepo)
    {
        $this->detailDevisRepository = $detailDevisRepo;
    }

    /**
     * Display a listing of the DetailDevis.
     * GET|HEAD /detail-devis
     */
    public function index(Request $request): JsonResponse
    {
        $detailDevis = $this->detailDevisRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($detailDevis->toArray(), 'Detail Devis retrieved successfully');
    }

    /**
     * Store a newly created DetailDevis in storage.
     * POST /detail-devis
     */
    public function store(CreateDetailDevisAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $detailDevis = $this->detailDevisRepository->create($input);

        return $this->sendResponse($detailDevis->toArray(), 'Detail Devis saved successfully');
    }

    /**
     * Display the specified DetailDevis.
     * GET|HEAD /detail-devis/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DetailDevis $detailDevis */
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            return $this->sendError('Detail Devis not found');
        }

        return $this->sendResponse($detailDevis->toArray(), 'Detail Devis retrieved successfully');
    }

    /**
     * Update the specified DetailDevis in storage.
     * PUT/PATCH /detail-devis/{id}
     */
    public function update($id, UpdateDetailDevisAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DetailDevis $detailDevis */
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            return $this->sendError('Detail Devis not found');
        }

        $detailDevis = $this->detailDevisRepository->update($input, $id);

        return $this->sendResponse($detailDevis->toArray(), 'DetailDevis updated successfully');
    }

    /**
     * Remove the specified DetailDevis from storage.
     * DELETE /detail-devis/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DetailDevis $detailDevis */
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            return $this->sendError('Detail Devis not found');
        }

        $detailDevis->delete();

        return $this->sendSuccess('Detail Devis deleted successfully');
    }
}
