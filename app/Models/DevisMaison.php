<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DevisMaison extends Model
{
    use HasFactory;
    public $table = 'devis_maison';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'reference',
        'client_id',
        'maison_id',
        'finition_id',
        'taux_finition',
        'datedevis',
        'datedebut',
        'lieu'
    ];

    protected $casts = [
    ];

    public static array $rules = [
    ];
    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }
    public function maison(){
        return $this->belongsTo(Maison::class,'maison_id');
    }
    public function finition(){
        return $this->belongsTo(Finition::class,'finition_id');
    }
    public function detailDevis(){
        return $this->hasMany(DetailDevis::class,'devis_maison_id');
    }
    public function paiement(){
        return $this->hasMany(Paiement::class,'devis_maison_id');
    }
    public static function generateDevis(){
        $csvDevis = CsvDevis::all();
        foreach ($csvDevis as $devi){
            $d = new DevisMaison();
            $d->reference = $devi->reference;
            $d->client_id = Client::getBynumero($devi->client);
            $d->maison_id = Maison::getByNom($devi->maison);
            $d->finition_id = Finition::getByNom($devi->finition);
            $d->taux_finition = $devi->taux_finition;
            $d->datedevis = $devi->datedevis;
            $d->datedebut = $devi->datedebut;
            $d->lieu = $devi->lieu;
            $d->etat = 0;
            $d->save();
        }
    }
    public static function generateDetailDevis(){
        $devis = DevisMaison::all();
        foreach ($devis as $d){
            foreach ($d->maison->comptes as $compte){
                $detail = new DetailDevis();
                $detail->devis_maison_id = $d->id;
                $detail->compte_id = $compte->id;
                $detail->quantite = $compte->quantite;
                $detail->pu = $compte->pu;
                $detail->save();
            }
        }
    }
    public static function insertGetId($data){
        $id = DB::table('devis_maison')->insertGetId([
            'reference' => $data['reference'],
            'client_id' => $data['client_id'],
            'maison_id' => $data['maison_id'],
            'finition_id' => $data['finition_id'],
            'taux_finition' => $data['taux_finition'],
            'datedevis' => $data['datedevis'],
            'datedebut' => $data['datedebut'],
            'lieu' => $data['lieu']
        ]);

        return $id;
    }

    public static function getTotalPrix($devisMaisonid){
        $devisMaison = DevisMaison::find($devisMaisonid);
        $bigTotal = 0;
        foreach ($devisMaison->detailDevis as $details){
            $total = $details->quantite * $details->pu;
            $bigTotal += $total;
        }
        $finition = ($devisMaison->taux_finition * $bigTotal ) / 100;
        $net = $bigTotal+$finition;
        return $net;
    }
    public static function getPayer($devi_id){
        $result =  DB::table('montant_payer')->where('devis_maison_id', $devi_id)->first();
        if($result){
            return $result->payer;
        }
        return 0;
    }
    public static function getMontantParAnne($annee){
        $result = DB::select("select
        EXTRACT(MONTH FROM datedevis) as mois,
        COALESCE(sum(montant_net.total_prix),0) as total
        from montant_net
        where EXTRACT(YEAR FROM datedevis) = ?
        GROUP BY
        mois order by mois asc",[$annee]);
        if(!empty($result)){
            return $result;
        }
        return null;
    }
    public static function getDisticntAnnee(){
        $result = DB::select("SELECT DISTINCT EXTRACT(YEAR FROM datedevis) AS year FROM devis_maison order by year desc");
        if(!empty($result)){
            return $result;
        }
        return null;
    }

}
