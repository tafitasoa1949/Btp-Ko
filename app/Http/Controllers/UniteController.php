<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUniteRequest;
use App\Http\Requests\UpdateUniteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UniteRepository;
use Illuminate\Http\Request;
use Flash;

class UniteController extends AppBaseController
{
    /** @var UniteRepository $uniteRepository*/
    private $uniteRepository;

    public function __construct(UniteRepository $uniteRepo)
    {
        $this->uniteRepository = $uniteRepo;
    }

    /**
     * Display a listing of the Unite.
     */
    public function index(Request $request)
    {
        $unites = $this->uniteRepository->paginate(10);

        return view('unites.index')
            ->with('unites', $unites);
    }

    /**
     * Show the form for creating a new Unite.
     */
    public function create()
    {
        return view('unites.create');
    }

    /**
     * Store a newly created Unite in storage.
     */
    public function store(CreateUniteRequest $request)
    {
        $input = $request->all();

        $unite = $this->uniteRepository->create($input);

        Flash::success('Unite saved successfully.');

        return redirect(route('unites.index'));
    }

    /**
     * Display the specified Unite.
     */
    public function show($id)
    {
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            Flash::error('Unite not found');

            return redirect(route('unites.index'));
        }

        return view('unites.show')->with('unite', $unite);
    }

    /**
     * Show the form for editing the specified Unite.
     */
    public function edit($id)
    {
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            Flash::error('Unite not found');

            return redirect(route('unites.index'));
        }

        return view('unites.edit')->with('unite', $unite);
    }

    /**
     * Update the specified Unite in storage.
     */
    public function update($id, UpdateUniteRequest $request)
    {
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            Flash::error('Unite not found');

            return redirect(route('unites.index'));
        }

        $unite = $this->uniteRepository->update($request->all(), $id);

        Flash::success('Unite updated successfully.');

        return redirect(route('unites.index'));
    }

    /**
     * Remove the specified Unite from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $unite = $this->uniteRepository->find($id);

        if (empty($unite)) {
            Flash::error('Unite not found');

            return redirect(route('unites.index'));
        }

        $this->uniteRepository->delete($id);

        Flash::success('Unite deleted successfully.');

        return redirect(route('unites.index'));
    }
}
