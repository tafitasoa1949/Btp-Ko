<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeRequest;
use App\Http\Requests\UpdateEmployeRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Employe;
use App\Models\Poste;
use App\Repositories\EmployeRepository;
use Illuminate\Http\Request;
use Flash;

class EmployeController extends AppBaseController
{
    /** @var EmployeRepository $employeRepository*/
    private $employeRepository;

    public function __construct(EmployeRepository $employeRepo)
    {
        $this->employeRepository = $employeRepo;
    }

    /**
     * Display a listing of the Employe.
     */
    public function index(Request $request)
    {
        $employes = $this->employeRepository->paginate(10);

        return view('employes.index')
            ->with('employes', $employes);
    }

    /**
     * Show the form for creating a new Employe.
     */
    public function create()
    {
        $postes = Poste::all();
        return view('employes.create',[
            'postes' => $postes
        ]);
    }

    /**
     * Store a newly created Employe in storage.
     */
    public function store(CreateEmployeRequest $request)
    {
        $input = $request->all();
        $input['id'] = Employe::getId();
        $employe = $this->employeRepository->create($input);

        Flash::success('Employe saved successfully.');

        return redirect(route('employes.index'));
    }

    /**
     * Display the specified Employe.
     */
    public function show($id)
    {
        $employe = $this->employeRepository->find($id);
        $postes = Poste::all();
        if (empty($employe)) {
            Flash::error('Employe not found');

            return redirect(route('employes.index'));
        }

        return view('employes.show',[
            'employe' => $employe,
            'postes' => $postes
        ]);
    }

    /**
     * Show the form for editing the specified Employe.
     */
    public function edit($id)
    {
        $employe = $this->employeRepository->find($id);
        $postes = Poste::all();
        if (empty($employe)) {
            Flash::error('Employe not found');

            return redirect(route('employes.index'));
        }

        return view('employes.edit',[
            'employe' => $employe,
            'postes' => $postes
        ]);
    }

    /**
     * Update the specified Employe in storage.
     */
    public function update($id, UpdateEmployeRequest $request)
    {
        $employe = $this->employeRepository->find($id);

        if (empty($employe)) {
            Flash::error('Employe not found');

            return redirect(route('employes.index'));
        }

        $employe = $this->employeRepository->update($request->all(), $id);

        Flash::success('Employe updated successfully.');

        return redirect(route('employes.index'));
    }

    /**
     * Remove the specified Employe from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employe = $this->employeRepository->find($id);

        if (empty($employe)) {
            Flash::error('Employe not found');

            return redirect(route('employes.index'));
        }

        $this->employeRepository->delete($id);

        Flash::success('Employe deleted successfully.');

        return redirect(route('employes.index'));
    }
}
