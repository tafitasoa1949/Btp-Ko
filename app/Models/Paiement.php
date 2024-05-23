<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class Paiement extends Model
{
    public $table = 'paiement';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'devis_maison_id',
        'reference',
        'montant',
        'date'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'reference' => 'required',
//        'montant' => 'required|numeric|min:100',
        'montant' => 'required|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
        'date' => 'required|date|before:tomorrow'
    ];
    public static $messages = [
        'reference.required' => 'Le champ reference est obligatoire.',
        'montant.regex' => 'Le montant doit etre un chiffre.',
        'montant.required' => 'Le montant doit etre un chiffre.',
        'montant.min' => 'Le montant doit etre superieur à 100.',
        'date.required' => 'Le date est obligatoire.',
        'date.date' => 'Erreur sur le format de la date',
        'date.before' => 'Le date ne peut pas être dans le futur',
    ];
    public static function insert($data){
        $paiement = new Paiement();
        $paiement->devis_maison_id = $data['devis_maison_id'];
        $paiement->reference = $data['reference'];
        $paiement->montant = $data['montant'];
        $paiement->date = $data['date'];
        $paiement->save();
    }
    public function devisMaison(){
        return $this->belongsTo(DevisMaison::class,'devis_maison_id');
    }
    public static function getTotal(){
        $result = DB::select("select sum(montant) as paiement_total from paiement");
        if(!empty($result)){
            return $result[0]->paiement_total;
        }
        return 0;
    }
    public static function paiementClient($client_id){
        $result = DB::select("select p.*
            from paiement as p
            join devis_maison  as de on de.id = p.devis_maison_id
            where de.client_id = ?",[$client_id]);
        if (!empty($result)){
            return $result;
        }
        return null;
    }
}
