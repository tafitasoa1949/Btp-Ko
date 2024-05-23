<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFinitionRequest;
use App\Http\Requests\UpdateFinitionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\FinitionRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;

class FinitionController extends AppBaseController
{
    /** @var FinitionRepository $finitionRepository*/
    private $finitionRepository;

    public function __construct(FinitionRepository $finitionRepo)
    {
        $this->finitionRepository = $finitionRepo;
    }

    /**
     * Display a listing of the Finition.
     */
    public function index(Request $request)
    {
        $finitions = $this->finitionRepository->paginate(10);

        return view('finitions.index')
            ->with('finitions', $finitions);
    }

    /**
     * Show the form for creating a new Finition.
     */
    public function create()
    {
        return view('finitions.create');
    }

    /**
     * Store a newly created Finition in storage.
     */
    public function store(CreateFinitionRequest $request)
    {
        $input = $request->all();

        $finition = $this->finitionRepository->create($input);

        Flash::success('Finition saved successfully.');

        return redirect(route('finitions.index'));
    }

    /**
     * Display the specified Finition.
     */
    public function show($id)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        return view('finitions.show')->with('finition', $finition);
    }

    /**
     * Show the form for editing the specified Finition.
     */
    public function edit($id)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        return view('finitions.edit')->with('finition', $finition);
    }

    /**
     * Update the specified Finition in storage.
     */
    public function update($id, UpdateFinitionRequest $request)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        $finition = $this->finitionRepository->update($request->all(), $id);

        Flash::success('Finition updated successfully.');

        return redirect(route('finitions.index'));
    }

    /**
     * Remove the specified Finition from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finition = $this->finitionRepository->find($id);
        try {
            if (empty($finition)) {
                Flash::error('Finition not found');
                return redirect(route('finitions.index'));
            }
            $this->finitionRepository->delete($id);
            Flash::success('Finition deleted successfully.');
            return redirect(route('finitions.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Cette finition ne peut pas être supprimée'); // Utilisez Flash::error pour signaler l'erreur
            return redirect(route('finitions.index'))->with('errors', ['error' => 'Cette finition ne peut pas être supprimée']); // Ajoutez l'erreur à la session
        }
    }
}
