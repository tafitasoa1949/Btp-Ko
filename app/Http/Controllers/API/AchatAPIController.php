<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAchatAPIRequest;
use App\Http\Requests\API\UpdateAchatAPIRequest;
use App\Models\Achat;
use App\Repositories\AchatRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AchatAPIController
 */
class AchatAPIController extends AppBaseController
{
    private AchatRepository $achatRepository;

    public function __construct(AchatRepository $achatRepo)
    {
        $this->achatRepository = $achatRepo;
    }

    /**
     * Display a listing of the Achats.
     * GET|HEAD /achats
     */
    public function index(Request $request): JsonResponse
    {
        $achats = $this->achatRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($achats->toArray(), 'Achats retrieved successfully');
    }

    /**
     * Store a newly created Achat in storage.
     * POST /achats
     */
    public function store(CreateAchatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $achat = $this->achatRepository->create($input);

        return $this->sendResponse($achat->toArray(), 'Achat saved successfully');
    }

    /**
     * Display the specified Achat.
     * GET|HEAD /achats/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Achat $achat */
        $achat = $this->achatRepository->find($id);

        if (empty($achat)) {
            return $this->sendError('Achat not found');
        }

        return $this->sendResponse($achat->toArray(), 'Achat retrieved successfully');
    }

    /**
     * Update the specified Achat in storage.
     * PUT/PATCH /achats/{id}
     */
    public function update($id, UpdateAchatAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Achat $achat */
        $achat = $this->achatRepository->find($id);

        if (empty($achat)) {
            return $this->sendError('Achat not found');
        }

        $achat = $this->achatRepository->update($input, $id);

        return $this->sendResponse($achat->toArray(), 'Achat updated successfully');
    }

    /**
     * Remove the specified Achat from storage.
     * DELETE /achats/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Achat $achat */
        $achat = $this->achatRepository->find($id);

        if (empty($achat)) {
            return $this->sendError('Achat not found');
        }

        $achat->delete();

        return $this->sendSuccess('Achat deleted successfully');
    }
}
