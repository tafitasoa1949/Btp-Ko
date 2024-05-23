<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTarifAchatRequest;
use App\Http\Requests\UpdateTarifAchatRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TarifAchatRepository;
use Illuminate\Http\Request;
use Flash;

class TarifAchatController extends AppBaseController
{
    /** @var TarifAchatRepository $tarifAchatRepository*/
    private $tarifAchatRepository;

    public function __construct(TarifAchatRepository $tarifAchatRepo)
    {
        $this->tarifAchatRepository = $tarifAchatRepo;
    }

    /**
     * Display a listing of the TarifAchat.
     */
    public function index(Request $request)
    {
        $tarifAchats = $this->tarifAchatRepository->paginate(10);

        return view('tarif_achats.index')
            ->with('tarifAchats', $tarifAchats);
    }

    /**
     * Show the form for creating a new TarifAchat.
     */
    public function create()
    {
        return view('tarif_achats.create');
    }

    /**
     * Store a newly created TarifAchat in storage.
     */
    public function store(CreateTarifAchatRequest $request)
    {
        $input = $request->all();

        $tarifAchat = $this->tarifAchatRepository->create($input);

        Flash::success('Tarif Achat saved successfully.');

        return redirect(route('tarifAchats.index'));
    }

    /**
     * Display the specified TarifAchat.
     */
    public function show($id)
    {
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            Flash::error('Tarif Achat not found');

            return redirect(route('tarifAchats.index'));
        }

        return view('tarif_achats.show')->with('tarifAchat', $tarifAchat);
    }

    /**
     * Show the form for editing the specified TarifAchat.
     */
    public function edit($id)
    {
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            Flash::error('Tarif Achat not found');

            return redirect(route('tarifAchats.index'));
        }

        return view('tarif_achats.edit')->with('tarifAchat', $tarifAchat);
    }

    /**
     * Update the specified TarifAchat in storage.
     */
    public function update($id, UpdateTarifAchatRequest $request)
    {
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            Flash::error('Tarif Achat not found');

            return redirect(route('tarifAchats.index'));
        }

        $tarifAchat = $this->tarifAchatRepository->update($request->all(), $id);

        Flash::success('Tarif Achat updated successfully.');

        return redirect(route('tarifAchats.index'));
    }

    /**
     * Remove the specified TarifAchat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tarifAchat = $this->tarifAchatRepository->find($id);

        if (empty($tarifAchat)) {
            Flash::error('Tarif Achat not found');

            return redirect(route('tarifAchats.index'));
        }

        $this->tarifAchatRepository->delete($id);

        Flash::success('Tarif Achat deleted successfully.');

        return redirect(route('tarifAchats.index'));
    }
}
