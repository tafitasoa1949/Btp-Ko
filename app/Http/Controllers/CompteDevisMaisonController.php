<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCompteDevisMaisonRequest;
use App\Http\Requests\UpdateCompteDevisMaisonRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CompteDevisMaisonRepository;
use Illuminate\Http\Request;
use Flash;

class CompteDevisMaisonController extends AppBaseController
{
    /** @var CompteDevisMaisonRepository $compteDevisMaisonRepository*/
    private $compteDevisMaisonRepository;

    public function __construct(CompteDevisMaisonRepository $compteDevisMaisonRepo)
    {
        $this->compteDevisMaisonRepository = $compteDevisMaisonRepo;
    }

    /**
     * Display a listing of the CompteDevisMaison.
     */
    public function index(Request $request)
    {
        $compteDevisMaisons = $this->compteDevisMaisonRepository->paginate(10);

        return view('compte_devis_maisons.index')
            ->with('compteDevisMaisons', $compteDevisMaisons);
    }

    /**
     * Show the form for creating a new CompteDevisMaison.
     */
    public function create()
    {
        return view('compte_devis_maisons.create');
    }

    /**
     * Store a newly created CompteDevisMaison in storage.
     */
    public function store(CreateCompteDevisMaisonRequest $request)
    {
        $input = $request->all();

        $compteDevisMaison = $this->compteDevisMaisonRepository->create($input);

        Flash::success('Compte Devis Maison saved successfully.');

        return redirect(route('compteDevisMaisons.index'));
    }

    /**
     * Display the specified CompteDevisMaison.
     */
    public function show($id)
    {
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            Flash::error('Compte Devis Maison not found');

            return redirect(route('compteDevisMaisons.index'));
        }

        return view('compte_devis_maisons.show')->with('compteDevisMaison', $compteDevisMaison);
    }

    /**
     * Show the form for editing the specified CompteDevisMaison.
     */
    public function edit($id)
    {
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            Flash::error('Compte Devis Maison not found');

            return redirect(route('compteDevisMaisons.index'));
        }

        return view('compte_devis_maisons.edit')->with('compteDevisMaison', $compteDevisMaison);
    }

    /**
     * Update the specified CompteDevisMaison in storage.
     */
    public function update($id, UpdateCompteDevisMaisonRequest $request)
    {
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            Flash::error('Compte Devis Maison not found');

            return redirect(route('compteDevisMaisons.index'));
        }

        $compteDevisMaison = $this->compteDevisMaisonRepository->update($request->all(), $id);

        Flash::success('Compte Devis Maison updated successfully.');

        return redirect(route('compteDevisMaisons.index'));
    }

    /**
     * Remove the specified CompteDevisMaison from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $compteDevisMaison = $this->compteDevisMaisonRepository->find($id);

        if (empty($compteDevisMaison)) {
            Flash::error('Compte Devis Maison not found');

            return redirect(route('compteDevisMaisons.index'));
        }

        $this->compteDevisMaisonRepository->delete($id);

        Flash::success('Compte Devis Maison deleted successfully.');

        return redirect(route('compteDevisMaisons.index'));
    }
}
