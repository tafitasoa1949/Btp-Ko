<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailDevisRequest;
use App\Http\Requests\UpdateDetailDevisRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DetailDevisRepository;
use Illuminate\Http\Request;
use Flash;

class DetailDevisController extends AppBaseController
{
    /** @var DetailDevisRepository $detailDevisRepository*/
    private $detailDevisRepository;

    public function __construct(DetailDevisRepository $detailDevisRepo)
    {
        $this->detailDevisRepository = $detailDevisRepo;
    }

    /**
     * Display a listing of the DetailDevis.
     */
    public function index(Request $request)
    {
        $detailDevis = $this->detailDevisRepository->paginate(10);

        return view('detail_devis.index')
            ->with('detailDevis', $detailDevis);
    }

    /**
     * Show the form for creating a new DetailDevis.
     */
    public function create()
    {
        return view('detail_devis.create');
    }

    /**
     * Store a newly created DetailDevis in storage.
     */
    public function store(CreateDetailDevisRequest $request)
    {
        $input = $request->all();

        $detailDevis = $this->detailDevisRepository->create($input);

        Flash::success('Detail Devis saved successfully.');

        return redirect(route('detailDevis.index'));
    }

    /**
     * Display the specified DetailDevis.
     */
    public function show($id)
    {
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            Flash::error('Detail Devis not found');

            return redirect(route('detailDevis.index'));
        }

        return view('detail_devis.show')->with('detailDevis', $detailDevis);
    }

    /**
     * Show the form for editing the specified DetailDevis.
     */
    public function edit($id)
    {
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            Flash::error('Detail Devis not found');

            return redirect(route('detailDevis.index'));
        }

        return view('detail_devis.edit')->with('detailDevis', $detailDevis);
    }

    /**
     * Update the specified DetailDevis in storage.
     */
    public function update($id, UpdateDetailDevisRequest $request)
    {
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            Flash::error('Detail Devis not found');

            return redirect(route('detailDevis.index'));
        }

        $detailDevis = $this->detailDevisRepository->update($request->all(), $id);

        Flash::success('Detail Devis updated successfully.');

        return redirect(route('detailDevis.index'));
    }

    /**
     * Remove the specified DetailDevis from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detailDevis = $this->detailDevisRepository->find($id);

        if (empty($detailDevis)) {
            Flash::error('Detail Devis not found');

            return redirect(route('detailDevis.index'));
        }

        $this->detailDevisRepository->delete($id);

        Flash::success('Detail Devis deleted successfully.');

        return redirect(route('detailDevis.index'));
    }
}
