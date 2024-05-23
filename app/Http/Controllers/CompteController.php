<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompteRequest;
use App\Http\Requests\UpdateCompteRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Unite;
use App\Repositories\CompteRepository;
use Illuminate\Http\Request;
use Flash;

class CompteController extends AppBaseController
{
    /** @var CompteRepository $compteRepository*/
    private $compteRepository;

    public function __construct(CompteRepository $compteRepo)
    {
        $this->compteRepository = $compteRepo;
    }

    /**
     * Display a listing of the Compte.
     */
    public function index(Request $request)
    {
        $comptes = $this->compteRepository->paginate(10);

        return view('comptes.index')
            ->with('comptes', $comptes);
    }

    /**
     * Show the form for creating a new Compte.
     */
    public function create()
    {
        return view('comptes.create');
    }

    /**
     * Store a newly created Compte in storage.
     */
    public function store(CreateCompteRequest $request)
    {
        $input = $request->all();

        $compte = $this->compteRepository->create($input);

        Flash::success('Compte saved successfully.');

        return redirect(route('comptes.index'));
    }

    /**
     * Display the specified Compte.
     */
    public function show($id)
    {
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            Flash::error('Compte not found');

            return redirect(route('comptes.index'));
        }

        return view('comptes.show')->with('compte', $compte);
    }

    /**
     * Show the form for editing the specified Compte.
     */
    public function edit($id)
    {
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            Flash::error('Compte not found');

            return redirect(route('comptes.index'));
        }
        $unites = Unite::all();
        return view('comptes.edit',[
            'unites' => $unites,
            'compte' => $compte
        ]);
    }

    /**
     * Update the specified Compte in storage.
     */
    public function update($id, UpdateCompteRequest $request)
    {
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            Flash::error('Compte not found');

            return redirect(route('comptes.index'));
        }

        $compte = $this->compteRepository->update($request->all(), $id);

        Flash::success('Compte updated successfully.');

        return redirect(route('comptes.index'));
    }

    /**
     * Remove the specified Compte from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $compte = $this->compteRepository->find($id);

        if (empty($compte)) {
            Flash::error('Compte not found');

            return redirect(route('comptes.index'));
        }

        $this->compteRepository->delete($id);

        Flash::success('Compte deleted successfully.');

        return redirect(route('comptes.index'));
    }
}
