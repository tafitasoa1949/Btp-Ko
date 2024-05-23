<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEmployeAPIRequest;
use App\Http\Requests\API\UpdateEmployeAPIRequest;
use App\Models\Employe;
use App\Repositories\EmployeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class EmployeAPIController
 */
class EmployeAPIController extends AppBaseController
{
    private EmployeRepository $employeRepository;

    public function __construct(EmployeRepository $employeRepo)
    {
        $this->employeRepository = $employeRepo;
    }

    /**
     * Display a listing of the Employes.
     * GET|HEAD /employes
     */
    public function index(Request $request): JsonResponse
    {
        $employes = $this->employeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($employes->toArray(), 'Employes retrieved successfully');
    }

    /**
     * Store a newly created Employe in storage.
     * POST /employes
     */
    public function store(CreateEmployeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $employe = $this->employeRepository->create($input);

        return $this->sendResponse($employe->toArray(), 'Employe saved successfully');
    }

    /**
     * Display the specified Employe.
     * GET|HEAD /employes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Employe $employe */
        $employe = $this->employeRepository->find($id);

        if (empty($employe)) {
            return $this->sendError('Employe not found');
        }

        return $this->sendResponse($employe->toArray(), 'Employe retrieved successfully');
    }

    /**
     * Update the specified Employe in storage.
     * PUT/PATCH /employes/{id}
     */
    public function update($id, UpdateEmployeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Employe $employe */
        $employe = $this->employeRepository->find($id);

        if (empty($employe)) {
            return $this->sendError('Employe not found');
        }

        $employe = $this->employeRepository->update($input, $id);

        return $this->sendResponse($employe->toArray(), 'Employe updated successfully');
    }

    /**
     * Remove the specified Employe from storage.
     * DELETE /employes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Employe $employe */
        $employe = $this->employeRepository->find($id);

        if (empty($employe)) {
            return $this->sendError('Employe not found');
        }

        $employe->delete();

        return $this->sendSuccess('Employe deleted successfully');
    }
}
