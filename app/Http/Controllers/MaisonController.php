<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaisonRequest;
use App\Http\Requests\UpdateMaisonRequest;
use App\Http\Controllers\AppBaseController;
use App\Imports\DevisImport;
use App\Imports\MaisonImport;
use App\Models\CsvDevis;
use App\Models\CsvMaison;
use App\Models\DevisMaison;
use App\Models\Maison;
use App\Repositories\MaisonRepository;
use Illuminate\Http\Request;
use Flash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use \DateTime;

class MaisonController extends AppBaseController
{
    /** @var MaisonRepository $maisonRepository*/
    private $maisonRepository;

    public function __construct(MaisonRepository $maisonRepo)
    {
        $this->maisonRepository = $maisonRepo;
    }

    /**
     * Display a listing of the Maison.
     */
    public function index()
    {
        $maisons = $this->maisonRepository->paginate(9);

        return view('maisons.index', [
            'maisons' => $maisons
        ]);
    }


    /**
     * Show the form for creating a new Maison.
     */
    public function create()
    {
        return view('maisons.create');
    }

    /**
     * Store a newly created Maison in storage.
     */
    public function store(CreateMaisonRequest $request)
    {
        $input = $request->all();

        $maison = $this->maisonRepository->create($input);

        Flash::success('Maison saved successfully.');

        return redirect(route('maisons.index'));
    }

    /**
     * Display the specified Maison.
     */
    public function show($id)
    {
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            Flash::error('Maison not found');

            return redirect(route('maisons.index'));
        }

        return view('maisons.show')->with('maison', $maison);
    }

    /**
     * Show the form for editing the specified Maison.
     */
    public function edit($id)
    {
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            Flash::error('Maison not found');

            return redirect(route('maisons.index'));
        }

        return view('maisons.edit')->with('maison', $maison);
    }

    /**
     * Update the specified Maison in storage.
     */
    public function update($id, UpdateMaisonRequest $request)
    {
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            Flash::error('Maison not found');

            return redirect(route('maisons.index'));
        }

        $maison = $this->maisonRepository->update($request->all(), $id);

        Flash::success('Maison updated successfully.');

        return redirect(route('maisons.index'));
    }

    /**
     * Remove the specified Maison from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $maison = $this->maisonRepository->find($id);

        if (empty($maison)) {
            Flash::error('Maison not found');

            return redirect(route('maisons.index'));
        }

        $this->maisonRepository->delete($id);

        Flash::success('Maison deleted successfully.');

        return redirect(route('maisons.index'));
    }
    public function import(Request $request){
        DB::beginTransaction();
        try {
            if ($request->hasFile('file') && $request->hasFile('filedevis')) {
//            maison et travaux
                $file = $request->file("file");
                $nomFichier = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $file->move(public_path('upload'), $nomFichier);
                $data = Excel::toArray(new MaisonImport(), 'upload/'. $nomFichier);
                $error = [];
                $tab = [];
//            convertion virgule en point et emplacement de données
                foreach($data as $tableau){
                    for($i = 0 ; $i < count($tableau); $i++){
                        if(isset($tableau[$i])){
                            $tableau[$i]['surface'] = str_replace(',', '.', $tableau[$i]['surface']);
                            $tableau[$i]['prix_unitaire'] = str_replace(',', '.', $tableau[$i]['prix_unitaire']);
                            $tableau[$i]['quantite'] = str_replace(',', '.', $tableau[$i]['quantite']);
                            $tableau[$i]['duree_travaux'] = str_replace(',', '.', $tableau[$i]['duree_travaux']);
                        }
                    }
                    array_push($tab,$tableau);
                }
//             teste erreur maison et travaux
                foreach ($tab as $data){
                    for($i = 0 ; $i < count($data) ; $i++){
                        if(!Maison::checkNombre($data[$i]['surface'])){
                            $error[] = "Erreur sur le fichier maison .Surface à la ligne ". ($i + 1)." : ".$data[$i]['surface'];
                        }
                        if(!Maison::checkNombre($data[$i]['prix_unitaire'])){
                            $error[] = "Erreur sur le fichier maison .Prix unitaire pour la ligne ". ($i + 1)." : ".$data[$i]['prix_unitaire'];
                        }
                        if(!Maison::checkNombre($data[$i]['quantite'])){
                            $error[] = "Erreur sur le fichier maison la quantite pour la ligne ". ($i + 1)." : ".$data[$i]['quantite'];
                        }
                        if(!Maison::checkNombre($data[$i]['duree_travaux'])){
                            $error[] = "Erreur sur le fichier maison la durée de travaux pour la ligne ". ($i + 1)." : ".$data[$i]['duree_travaux'];
                        }
                    }
                }
//            devis
                $filedevis = $request->file("filedevis");
                $nomFichierdevis = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $filedevis->move(public_path('upload'), $nomFichierdevis);
                $dataDevis = Excel::toArray(new DevisImport(), 'upload/'. $nomFichierdevis);
                $tabDevis = [];
                foreach($dataDevis as $tableauDevis){
                    for($i = 0 ; $i < count($tableauDevis); $i++){
                        if(isset($tableauDevis[$i])){
                            $tableauDevis[$i]['taux_finition'] = str_replace(',', '.', $tableauDevis[$i]['taux_finition']);
                            $tableauDevis[$i]['taux_finition'] = str_replace('%', '', $tableauDevis[$i]['taux_finition']);
                        }
                    }
                    array_push($tabDevis,$tableauDevis);
                }
//                teste erreur devis
                foreach ($tabDevis as $devis){
                    for($i = 0 ; $i < count($devis) ; $i++){
                        if(!Maison::checkNombre($devis[$i]['taux_finition'])){
                            $error[] = "Erreur sur le fichier devis .Taux finition à la ligne ". ($i + 1)." : ".$devis[$i]['taux_finition'];
                        }
                        if(!Maison::checkDate($devis[$i]['date_devis'])){
                            $error[] = "Erreur sur le fichier devis .Date de devis à la ligne ". ($i + 1)." : ".$devis[$i]['date_devis'];
                        }
                        if(!Maison::checkDate($devis[$i]['date_debut'])){
                            $error[] = "Erreur sur le fichier devis .Date de debut à la ligne ". ($i + 1)." : ".$devis[$i]['date_debut'];
                        }
                    }
                }
                if(!empty($error)) {
                    return redirect()->back()->withErrors(['error' => $error]);
                }else{
//                maison et travaux
                    foreach ($tab as $data) {
                        for ($i = 0; $i < count($data) ; $i++) {
                            $dataMaison = array(
                                'maison' => $data[$i]['type_maison'],
                                'description' => $data[$i]['description'],
                                'surface' => $data[$i]['surface'],
                                'code' => $data[$i]['code_travaux'],
                                'nomcode' => $data[$i]['type_travaux'],
                                'unite' => $data[$i]['unite'],
                                'pu' => $data[$i]['prix_unitaire'],
                                'quantite' => $data[$i]['quantite'],
                                'duree' =>  $data[$i]['duree_travaux'],
                            );
                            CsvMaison::insert($dataMaison);
                        }
                    }
//                    devis
                    foreach ($tabDevis as $dataDev){
                        for ($i = 0; $i < count($dataDev) ; $i++) {
                            CsvDevis::create([
                                'client' => $dataDev[$i]['client'],
                                'reference' => $dataDev[$i]['ref_devis'],
                                'maison' => $dataDev[$i]['type_maison'],
                                'finition' => $dataDev[$i]['finition'],
                                'taux_finition' => $dataDev[$i]['taux_finition'],
                                'datedevis' => $dataDev[$i]['date_devis'],
                                'datedebut' => $dataDev[$i]['date_debut'],
                                'lieu' => $dataDev[$i]['lieu']
                            ]);
                        }
                    }
                    echo "ee";
                    Maison::generate_client();
                    Maison::generate_finition();
                    Maison::generate_unite();
                    Maison::generateMaison();
                    Maison::generateDetail();
                    Maison::generateCompte();
                    DevisMaison::generateDevis();
                    echo "dd";
                    DevisMaison::generateDetailDevis();
                    DB::commit();
                    return redirect()->route('maisons.index');
                }
            }
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
//            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'insertion.']);
        }
    }
}
