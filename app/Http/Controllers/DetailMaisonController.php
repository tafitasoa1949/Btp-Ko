<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailMaisonRequest;
use App\Http\Requests\UpdateDetailMaisonRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DetailMaisonRepository;
use Illuminate\Http\Request;
use Flash;

class DetailMaisonController extends AppBaseController
{
    /** @var DetailMaisonRepository $detailMaisonRepository*/
    private $detailMaisonRepository;

    public function __construct(DetailMaisonRepository $detailMaisonRepo)
    {
        $this->detailMaisonRepository = $detailMaisonRepo;
    }

    /**
     * Display a listing of the DetailMaison.
     */
    public function index(Request $request)
    {
        $detailMaisons = $this->detailMaisonRepository->paginate(10);

        return view('detail_maisons.index')
            ->with('detailMaisons', $detailMaisons);
    }

    /**
     * Show the form for creating a new DetailMaison.
     */
    public function create()
    {
        return view('detail_maisons.create');
    }

    /**
     * Store a newly created DetailMaison in storage.
     */
    public function store(CreateDetailMaisonRequest $request)
    {
        $input = $request->all();

        $detailMaison = $this->detailMaisonRepository->create($input);

        Flash::success('Detail Maison saved successfully.');

        return redirect(route('detailMaisons.index'));
    }

    /**
     * Display the specified DetailMaison.
     */
    public function show($id)
    {
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            Flash::error('Detail Maison not found');

            return redirect(route('detailMaisons.index'));
        }

        return view('detail_maisons.show')->with('detailMaison', $detailMaison);
    }

    /**
     * Show the form for editing the specified DetailMaison.
     */
    public function edit($id)
    {
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            Flash::error('Detail Maison not found');

            return redirect(route('detailMaisons.index'));
        }

        return view('detail_maisons.edit')->with('detailMaison', $detailMaison);
    }

    /**
     * Update the specified DetailMaison in storage.
     */
    public function update($id, UpdateDetailMaisonRequest $request)
    {
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            Flash::error('Detail Maison not found');

            return redirect(route('detailMaisons.index'));
        }

        $detailMaison = $this->detailMaisonRepository->update($request->all(), $id);

        Flash::success('Detail Maison updated successfully.');

        return redirect(route('detailMaisons.index'));
    }

    /**
     * Remove the specified DetailMaison from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detailMaison = $this->detailMaisonRepository->find($id);

        if (empty($detailMaison)) {
            Flash::error('Detail Maison not found');

            return redirect(route('detailMaisons.index'));
        }

        $this->detailMaisonRepository->delete($id);

        Flash::success('Detail Maison deleted successfully.');

        return redirect(route('detailMaisons.index'));
    }
}
