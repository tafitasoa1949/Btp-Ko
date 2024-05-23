<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDetailMaisonAPIRequest;
use App\Http\Requests\API\UpdateDetailMaisonAPIRequest;
use App\Models\DetailMaison;
use App\Repositories\DetailMaisonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DetailMaisonAPIController
 */
class DetailMaisonAPIController extends AppBaseController
{
    private DetailMaisonRepository $detailMaisonRepository;

    public function __construct(DetailMaisonRepository $detailMaisonRepo)
    {
        $this->detailMaisonRepository = $detailMaisonRepo;
    }

    /**
     * Display a listing of the DetailMaisons.
     * GET|HEAD /detail-maisons
     */
    public function index(Request $request): JsonResponse
    {
        $detailMaisons = $this->detailMaisonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($detailMaisons->toArray(), 'Detail Maisons retrieved successfully');
    }

    /**
     * Store a newly created DetailMaison in storage.
     * POST /detail-maisons
     */
    public function store(CreateDetailMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $detailMaison = $this->detailMaisonRepository->create($input);

        return $this->sendResponse($detailMaison->toArray(), 'Detail Maison saved successfully');
    }

    /**
     * Display the specified DetailMaison.
     * GET|HEAD /detail-maisons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var DetailMaison $detailMaison */
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            return $this->sendError('Detail Maison not found');
        }

        return $this->sendResponse($detailMaison->toArray(), 'Detail Maison retrieved successfully');
    }

    /**
     * Update the specified DetailMaison in storage.
     * PUT/PATCH /detail-maisons/{id}
     */
    public function update($id, UpdateDetailMaisonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DetailMaison $detailMaison */
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            return $this->sendError('Detail Maison not found');
        }

        $detailMaison = $this->detailMaisonRepository->update($input, $id);

        return $this->sendResponse($detailMaison->toArray(), 'DetailMaison updated successfully');
    }

    /**
     * Remove the specified DetailMaison from storage.
     * DELETE /detail-maisons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var DetailMaison $detailMaison */
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            return $this->sendError('Detail Maison not found');
        }

        $detailMaison->delete();

        return $this->sendSuccess('Detail Maison deleted successfully');
    }
}
