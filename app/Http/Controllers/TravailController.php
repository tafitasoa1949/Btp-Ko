<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTravailRequest;
use App\Http\Requests\UpdateTravailRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Compte;
use App\Models\Unite;
use App\Repositories\TravailRepository;
use Illuminate\Http\Request;
use Flash;

class TravailController extends AppBaseController
{
    /** @var TravailRepository $travailRepository*/
    private $travailRepository;

    public function __construct(TravailRepository $travailRepo)
    {
        $this->travailRepository = $travailRepo;
    }

    /**
     * Display a listing of the Travail.
     */
    public function index(Request $request)
    {
        $travails = $this->travailRepository->paginate(10);

        return view('travails.index')
            ->with('travails', $travails);
    }

    /**
     * Show the form for creating a new Travail.
     */
    public function create()
    {
        $comptes = Compte::all();
        $unite = Unite::all();
        return view('travails.create',[
            'comptes' => $comptes,
            'unites' => $unite
        ]);
    }

    /**
     * Store a newly created Travail in storage.
     */
    public function store(CreateTravailRequest $request)
    {
        $compte_id = $request->compte_id;
        $compte = Compte::find($compte_id);
        $code = $request->code;
        $prefixCode = substr($code, 0, 1);
        $prefixCompte = $compte? substr($compte->code, 0, 1) : '';
        if ($prefixCode!= $prefixCompte) {
            return back()->withErrors([
                'code' => 'Les préfixes doivent être correspondants à la préfixe du compte : '.$compte->code,
            ])->withInput();
        }
        $input = $request->all();

        $travail = $this->travailRepository->create($input);

        Flash::success('Travail saved successfully.');

        return redirect(route('travails.index'));
    }

    /**
     * Display the specified Travail.
     */
    public function show($id)
    {
        $travail = $this->travailRepository->find($id);

        if (empty($travail)) {
            Flash::error('Travail not found');

            return redirect(route('travails.index'));
        }

        return view('travails.show')->with('travail', $travail);
    }

    /**
     * Show the form for editing the specified Travail.
     */
    public function edit($id)
    {
        $travail = $this->travailRepository->find($id);
        $comptes = Compte::all();
        $unites = Unite::all();
        if (empty($travail)) {
            Flash::error('Travail not found');

            return redirect(route('travails.index'));
        }

        return view('travails.edit',[
            'travail' => $travail,
            'comptes' => $comptes,
            'unites' => $unites
        ]);
    }

    /**
     * Update the specified Travail in storage.
     */
    public function update($id, UpdateTravailRequest $request)
    {
        $travail = $this->travailRepository->find($id);
        $code = $request->code;
        $prefixCode = substr($code, 0, 1);
        $prefixCompte = $travail->compte? substr($travail->compte->code, 0, 1) : '';
        if ($prefixCode!= $prefixCompte) {
            return back()->withErrors([
                'code' => 'Les préfixes doivent être correspondants à la préfixe du compte :'.$travail->compte->code,
            ])->withInput();
        }
        if (empty($travail)) {
            Flash::error('Travail not found');

            return redirect(route('travails.index'));
        }

        $travail = $this->travailRepository->update($request->all(), $id);

        Flash::success('Travail updated successfully.');

        return redirect(route('travails.index'));
    }

    /**
     * Remove the specified Travail from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $travail = $this->travailRepository->find($id);

        if (empty($travail)) {
            Flash::error('Travail not found');

            return redirect(route('travails.index'));
        }

        $this->travailRepository->delete($id);

        Flash::success('Travail deleted successfully.');

        return redirect(route('travails.index'));
    }
}
