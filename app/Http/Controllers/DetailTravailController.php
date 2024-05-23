<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailTravailRequest;
use App\Http\Requests\UpdateDetailTravailRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DetailTravailRepository;
use Illuminate\Http\Request;
use Flash;

class DetailTravailController extends AppBaseController
{
    /** @var DetailTravailRepository $detailTravailRepository*/
    private $detailTravailRepository;

    public function __construct(DetailTravailRepository $detailTravailRepo)
    {
        $this->detailTravailRepository = $detailTravailRepo;
    }

    /**
     * Display a listing of the DetailTravail.
     */
    public function index(Request $request)
    {
        $detailTravails = $this->detailTravailRepository->paginate(10);

        return view('detail_travails.index')
            ->with('detailTravails', $detailTravails);
    }

    /**
     * Show the form for creating a new DetailTravail.
     */
    public function create()
    {
        return view('detail_travails.create');
    }

    /**
     * Store a newly created DetailTravail in storage.
     */
    public function store(CreateDetailTravailRequest $request)
    {
        $input = $request->all();

        $detailTravail = $this->detailTravailRepository->create($input);

        Flash::success('Detail Travail saved successfully.');

        return redirect(route('detailTravails.index'));
    }

    /**
     * Display the specified DetailTravail.
     */
    public function show($id)
    {
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            Flash::error('Detail Travail not found');

            return redirect(route('detailTravails.index'));
        }

        return view('detail_travails.show')->with('detailTravail', $detailTravail);
    }

    /**
     * Show the form for editing the specified DetailTravail.
     */
    public function edit($id)
    {
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            Flash::error('Detail Travail not found');

            return redirect(route('detailTravails.index'));
        }

        return view('detail_travails.edit')->with('detailTravail', $detailTravail);
    }

    /**
     * Update the specified DetailTravail in storage.
     */
    public function update($id, UpdateDetailTravailRequest $request)
    {
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            Flash::error('Detail Travail not found');

            return redirect(route('detailTravails.index'));
        }

        $detailTravail = $this->detailTravailRepository->update($request->all(), $id);

        Flash::success('Detail Travail updated successfully.');

        return redirect(route('detailTravails.index'));
    }

    /**
     * Remove the specified DetailTravail from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detailTravail = $this->detailTravailRepository->find($id);

        if (empty($detailTravail)) {
            Flash::error('Detail Travail not found');

            return redirect(route('detailTravails.index'));
        }

        $this->detailTravailRepository->delete($id);

        Flash::success('Detail Travail deleted successfully.');

        return redirect(route('detailTravails.index'));
    }
}
