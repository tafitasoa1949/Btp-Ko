<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaiementRequest;
use App\Http\Requests\UpdatePaiementRequest;
use App\Http\Controllers\AppBaseController;
use App\Imports\PaiementImport;
use App\Models\Achat;
use App\Models\DevisMaison;
use App\Models\Maison;
use App\Models\Paiement;
use App\Repositories\PaiementRepository;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use \DateTime;

class PaiementController extends AppBaseController
{
    /** @var PaiementRepository $paiementRepository*/
    private $paiementRepository;

    public function __construct(PaiementRepository $paiementRepo)
    {
        $this->paiementRepository = $paiementRepo;
    }

    /**
     * Display a listing of the Paiement.
     */
    public function index(Request $request)
    {
        $paiements = $this->paiementRepository->paginate(10);

        return view('paiements.index')
            ->with('paiements', $paiements);
    }

    /**
     * Show the form for creating a new Paiement.
     */
    public function create()
    {
        return view('paiements.create');
    }

    /**
     * Store a newly created Paiement in storage.
     */
    public function store(CreatePaiementRequest $request)
    {
        $input = $request->all();

        $paiement = $this->paiementRepository->create($input);

        Flash::success('Paiement saved successfully.');

        return redirect(route('paiements.index'));
    }

    /**
     * Display the specified Paiement.
     */
    public function show($id)
    {
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            Flash::error('Paiement not found');

            return redirect(route('paiements.index'));
        }

        return view('paiements.show')->with('paiement', $paiement);
    }

    /**
     * Show the form for editing the specified Paiement.
     */
    public function edit($id)
    {
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            Flash::error('Paiement not found');

            return redirect(route('paiements.index'));
        }

        return view('paiements.edit')->with('paiement', $paiement);
    }

    /**
     * Update the specified Paiement in storage.
     */
    public function update($id, UpdatePaiementRequest $request)
    {
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            Flash::error('Paiement not found');

            return redirect(route('paiements.index'));
        }

        $paiement = $this->paiementRepository->update($request->all(), $id);

        Flash::success('Paiement updated successfully.');

        return redirect(route('paiements.index'));
    }

    /**
     * Remove the specified Paiement from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $paiement = $this->paiementRepository->find($id);

        if (empty($paiement)) {
            Flash::error('Paiement not found');

            return redirect(route('paiements.index'));
        }

        $this->paiementRepository->delete($id);

        Flash::success('Paiement deleted successfully.');

        return redirect(route('paiements.index'));
    }
    public function paiement(){
        $client_id = session('client_id');
        if($client_id){
            $paiements = Paiement::paiementClient($client_id);
            return view('paiements.client',[
                'paiements' => $paiements
            ]);
        }else{
            return back()->withErrors([
                'numero' => "",
            ])->withInput();
        }
    }
    public function faire($id){
        $achat = Achat::find($id);
        $montantRecu = Achat::getPayer($id);
        $reste = $achat->tarifAchat->montant_total - $montantRecu;
        return view('paiements.payer',[
            'achat' => $achat,
            'montantRecu' => $montantRecu,
            'reste' => $reste
        ]);
    }

    public function payer_achat(Request $request)
    {
        $request->validate(Paiement::$rules, Paiement::$messages);
//        try {
            $devi_id = $request->input('devi_id');
            $montant = $request->input('montant');
            $reference = $request->input('reference');
            $date = $request->input('date');
            $client_id = session('client_id');

            $devisMaison = DevisMaison::find($devi_id);
            if (!$devisMaison) {
                return response()->json(['error' => 'Devis n existe pas'], 404);
            }

            $payementEffectue = $devisMaison->getPayer($devisMaison->id);
            $totalPrix = DevisMaison::getTotalPrix($devisMaison->id);
            $reste_a_payer = $totalPrix - $payementEffectue;

            if ($montant > $reste_a_payer) {
                return response()->json(['error' => 'Montant dépasse le reste à payer total de ce travail'], 400);
            }

            $paiement = new Paiement([
                'client_id' => $client_id,
                'devis_maison_id' => $devi_id,
                'montant' => $montant,
                'reference' => $reference,
                'date' => $date,
            ]);
            $paiement->save();

            return response()->json(['success' => "Insertion effectuée"], 201);
//        } catch (Exception $e) {
//            // Gestion des autres exceptions
//            return response()->json(['error' => $e->getMessage()], 500);
//        }

    }
    public function statistique(){
        $totalPaiment = Paiement::getTotal();
        return view('paiements.statistique',[
            'totalPaiment' => $totalPaiment
        ]);
    }
    public function import(Request $request){
        DB::beginTransaction();
        try {
//            echo "ff";
            if ($request->hasFile('file')) {

                $file = $request->file("file");
                $nomFichier = Carbon::now()->format('Ymd_His') .'_' . $file->getClientOriginalName();
                $file->move(public_path('upload'), $nomFichier);
                $data = Excel::toArray(new PaiementImport(), 'upload/'. $nomFichier);
                $error = [];
                $tab = [];
                foreach($data as $tableau){

                    for($i = 0 ; $i < count($tableau); $i++){
                        if(isset($tableau[$i])){
                            $tableau[$i]['montant'] = str_replace(',', '.', $tableau[$i]['montant']);
                        }
                    }
                    array_push($tab,$tableau);
                }
//                check
                dd($tab);
                foreach ($tab as $data){
                    for($i = 0 ; $i < count($data) ; $i++){
                        if(!Maison::checkNombre($data[$i]['montant'])){
                            $error[] = "Erreur sur le fichier paiement .Montant à la ligne ". ($i + 1)." : ".$data[$i]['montant'];
                        }
                        if(!Maison::checkDate($data[$i]['date_paiement'])){
                            $error[] = "Erreur sur le fichier paiment .Date de paiement à la ligne ". ($i + 1)." : ".$data[$i]['date_paiement'];
                        }
                    }
                }
                if(!empty($error)) {
                    return redirect()->back()->withErrors(['error' => $error]);
                }else{
                    $paiements = Paiement::all();
                    foreach ($tab as $data) {
//                        for ($i = 0; $i < count($data); $i++) {
//                            $term = false;
//                            foreach ($paiements as $pay){
//                                if($data[$i]['ref_paiement'].equalTo($pay->reference)){
//                                    $term = true;
//                                }
//                            }
//                            if($term == false){
//                                $deviMaison = DevisMaison::where('reference', $data[$i]['ref_devis'])->first();
//                                Paiement::create([
//                                    'devis_maison_id' => $deviMaison->id,
//                                    'reference' => $data[$i]['ref_paiement'],
//                                    'montant' => $data[$i]['montant'],
//                                    'date' => $data[$i]['date_paiement']
//                                ]);
//                            }
//
//                        }
                        for ($i = 0; $i < count($data); $i++) {
                            // Convertissez la collection Eloquent en tableau
                            $referencesArray = $paiements->pluck('reference')->toArray();
                            $term = array_search($data[$i]['ref_paiement'], array_column($referencesArray, 'reference'))!== false;
                            if (!$term) {
                                $deviMaison = DevisMaison::where('reference', $data[$i]['ref_devis'])->first();
                                if (!$deviMaison ||!Paiement::where('reference', $data[$i]['ref_paiement'])->exists()) {
                                    Paiement::create([
                                        'devis_maison_id' => $deviMaison->id,
                                        'reference' => $data[$i]['ref_paiement'],
                                        'montant' => $data[$i]['montant'],
                                        'date' => $data[$i]['date_paiement']
                                    ]);
                                }
                            }
                        }

                    }
                    DB::commit();
                    return redirect()->route('paiements.index');
                }
            }else{
                return redirect()->back()->withErrors(['error' => 'Le fichier paiement n existe pas.']);
            }
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'insertion.']);
        }
    }
}
