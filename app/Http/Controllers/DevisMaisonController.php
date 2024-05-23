<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDevisMaisonRequest;
use App\Http\Requests\UpdateDevisMaisonRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Achat;
use App\Models\DetailDevis;
use App\Models\DevisMaison;
use App\Models\Finition;
use App\Models\Maison;
use App\Models\TarifAchat;
use App\Repositories\DevisMaisonRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;

class DevisMaisonController extends AppBaseController
{
    /** @var DevisMaisonRepository $devisMaisonRepository*/
    private $devisMaisonRepository;

    public function __construct(DevisMaisonRepository $devisMaisonRepo)
    {
        $this->devisMaisonRepository = $devisMaisonRepo;
    }

    /**
     * Display a listing of the DevisMaison.
     */
    public function index(Request $request)
    {
        $devisMaisons = $this->devisMaisonRepository->paginate(9);

        return view('devis_maisons.index')
            ->with('devisMaisons', $devisMaisons);
    }

    /**
     * Show the form for creating a new DevisMaison.
     */
    public function create()
    {
        return view('devis_maisons.create');
    }

    /**
     * Store a newly created DevisMaison in storage.
     */
    public function store(CreateDevisMaisonRequest $request)
    {
        $input = $request->all();

        $devisMaison = $this->devisMaisonRepository->create($input);

        Flash::success('Devis Maison saved successfully.');

        return redirect(route('devisMaisons.index'));
    }

    /**
     * Display the specified DevisMaison.
     */
    public function show($id)
    {
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            Flash::error('Devis Maison not found');

            return redirect(route('devisMaisons.index'));
        }

        return view('devis_maisons.show')->with('devisMaison', $devisMaison);
    }

    /**
     * Show the form for editing the specified DevisMaison.
     */
    public function edit($id)
    {
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            Flash::error('Devis Maison not found');

            return redirect(route('devisMaisons.index'));
        }

        return view('devis_maisons.edit')->with('devisMaison', $devisMaison);
    }

    /**
     * Update the specified DevisMaison in storage.
     */
    public function update($id, UpdateDevisMaisonRequest $request)
    {
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            Flash::error('Devis Maison not found');

            return redirect(route('devisMaisons.index'));
        }

        $devisMaison = $this->devisMaisonRepository->update($request->all(), $id);

        Flash::success('Devis Maison updated successfully.');

        return redirect(route('devisMaisons.index'));
    }

    /**
     * Remove the specified DevisMaison from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $devisMaison = $this->devisMaisonRepository->find($id);

        if (empty($devisMaison)) {
            Flash::error('Devis Maison not found');

            return redirect(route('devisMaisons.index'));
        }

        $this->devisMaisonRepository->delete($id);

        Flash::success('Devis Maison deleted successfully.');

        return redirect(route('devisMaisons.index'));
    }
    public function image(){
        $client_id = session('client_id');
        $devisMaisons = DevisMaison::where('client_id',$client_id)->paginate(9);
        return view('devis_maisons.image',[
            'devisMaisons' => $devisMaisons
        ]);
    }
    public function export($id){
        $devisMaison = DevisMaison::find($id);
        if($devisMaison){
            $data = [
                'devisMaison' => $devisMaison
            ];

            $pdf = PDF::loadView('pdf.devis', $data);
            return $pdf->download('DevisMaison.pdf');
        }
    }
    public function exports($id){
        $devisMaison = DevisMaison::find($id);
        if($devisMaison){
            $data = [
                'devisMaison' => $devisMaison
            ];

            $pdf = PDF::loadView('pdf.devis', $data);
            return $pdf->download('DevisMaison.pdf');
        }
    }
    public function liste(){
        $maisons = Maison::paginate(9);
        return view('devis_maisons.liste',[
            'maisons' => $maisons
        ]);
    }
    public function details($id){
        $maison = Maison::find($id);
        if($maison){
            return view('devis_maisons.detail',[
                'maison' => $maison
            ]);
        }
    }
    public function creer($id){
        $maison = Maison::find($id);
        if($maison){
            $finitions = Finition::all();
            return view('devis_maisons.creation',[
                'maison' => $maison,
                'finitions' => $finitions
            ]);
        }
    }
    public function creation(Request $request){
        DB::beginTransaction();
        try {
            $maison_id = $request->input('maison_id');
            $maison = Maison::find($maison_id);
            if($maison){
                $finition_id = $request->input('finition_id');
                $finition = Finition::find($finition_id);
                $datedebut = $request->input('datedebut');
                $reference = $request->input('reference');
                $datedevis = $request->input('datedevis');
                $lieu = $request->input('lieu');
                $client_id = session('client_id');

                $dataDevisMaison = array(
                    'reference' => $reference,
                    'client_id' => $client_id,
                    'maison_id' => $maison_id,
                    'finition_id' => $finition_id,
                    'taux_finition' => $finition->pourcentage,
                    'datedevis' => $datedevis,
                    'datedebut' => $datedebut,
                    'lieu' => $lieu,
                );
                $idDevis = DevisMaison::insertGetId($dataDevisMaison);
                foreach ($maison->comptes as $compte){
                    $detailDevis = new DetailDevis();
                    $detailDevis->devis_maison_id = $idDevis;
                    $detailDevis->compte_id = $compte->id;
                    $detailDevis->quantite = $compte->quantite;
                    $detailDevis->pu = $compte->pu;
                    $detailDevis->save();
                }
                DB::commit();
                return redirect()->route('travaux');
            }else{
                return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'insertion.']);
            }
        }catch(\Exception $e){
            DB::rollBack();
            dd($e);
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'insertion.']);
        }
    }
    public function travaux(){
        $client_id = session('client_id');
        $devisMaisons = DevisMaison::where('client_id',$client_id)->paginate(10);
        $data = [];
        foreach ($devisMaisons as $a){
            $montantRecu = DevisMaison::getPayer($a->id);
            $totalPrix = DevisMaison::getTotalPrix($a->id);
            $prixfinition = ($a->taux_finition * $totalPrix)/100;
            $pourcentage = number_format(($montantRecu * 100) / $totalPrix, 2);
            $fin_projet = Maison::ajouterJours($a->datedebut,floatval($a->maison->duree));
            $totalNet =$totalPrix+$prixfinition;
            $achat = array(
                'devi_id'=> $a->id,
                'travail' => $a->maison->nom,
                'reference' => $a->reference,
                'debut' => $a->datedebut,
                'duree' => $a->maison->duree,
                'fin_travail' => $fin_projet,
                'finition' => $a->finition->nom,
                'prix' => $totalNet,
                'recu' => $montantRecu,
                'reste' => $totalPrix - $montantRecu,
                'pourcentage' => $pourcentage
            );
            array_push($data,$achat);
        }
        return view('devis_maisons.travaux',[
            'data' => $data,
            'pagination' => $devisMaisons
        ]);
    }
    public function devis(){
        $devisMaisons = DevisMaison::where('etat', '0')->orderBy('datedebut', 'desc')->paginate(10);
        $devi_final = [];
        foreach ($devisMaisons as $a){
            $montantRecu = DevisMaison::getPayer($a->id);
            $totalPrix = DevisMaison::getTotalPrix($a->id);
            $pourcentage = number_format(($montantRecu * 100) / $totalPrix, 2);
            $fin_projet = Maison::ajouterJours($a->datedebut,floatval($a->maison->duree));
            $money = array(
                'id' => $a->id,
                'travail' => $a->maison->nom,
                'reference' => $a->reference,
                'client' => $a->client->numero,
                'debut' => $a->datedebut,
                'duree' => $a->maison->duree,
                'fin_travail' => $fin_projet,
                'prix' => $totalPrix,
                'finition' => $a->finition->nom,
                'payer' => $montantRecu,
                'reste' =>  $totalPrix - $montantRecu,
                'pourcentage' => $pourcentage
            );
            array_push($devi_final,$money);
        }
        return view('devis_maisons.encours',[
            'achat_final' => $devi_final,
            'pagination' => $devisMaisons
        ]);
    }
    public function stat_devis(){
        $montantTotal = 0;
        $deviMaisons = DevisMaison::all();
        foreach ($deviMaisons as $devis){
            $totalprix = DevisMaison::getTotalPrix($devis->id);
            $montantTotal += $totalprix;
        }
        $anneeActuelle = Carbon::now()->format('Y');
        $anneDistinct = DevisMaison::getDisticntAnnee();
        $data = DevisMaison::getMontantParAnne($anneeActuelle);
        $dataStat = [];
        for ($i = 1; $i <= 12; $i++) {
            $montant = 0;
            if(!empty($data)){
                foreach ($data as $row) {
                    if($row->mois == $i) {
                        $montant = $row->total;
//                    break;
                    }
                }
            }
            array_push($dataStat,$montant);
        }
        return view('devis_maisons.histogramme',[
            'annee' => $anneeActuelle,
            'montantTotal' => $montantTotal,
            'dataStat' => $dataStat,
            'anneDistinct' => $anneDistinct
        ]);
    }
    public function stat_devisDate(Request $request){
        $montantTotal = 0;
        $deviMaisons = DevisMaison::all();
        foreach ($deviMaisons as $devis){
            $totalprix = DevisMaison::getTotalPrix($devis->id);
            $montantTotal += $totalprix;
        }
        $annee = $request->input('annee');
        $anneDistinct = DevisMaison::getDisticntAnnee();
        $data = DevisMaison::getMontantParAnne($annee);
        $dataStat = [];
        for ($i = 1; $i <= 12; $i++) {
            $montant = 0;
            if(!empty($data)){
                foreach ($data as $row) {
                    if($row->mois == $i) {
                        $montant = $row->total;
//                    break;
                    }
                }
            }
            array_push($dataStat,$montant);
        }
        return view('devis_maisons.histogramme',[
            'annee' => $annee,
            'montantTotal' => $montantTotal,
            'dataStat' => $dataStat,
            'anneDistinct' => $anneDistinct
        ]);
    }
}
