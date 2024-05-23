<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Achat extends Model
{
    public $table = 'achat';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'client_id',
        'devis_maison_id',
        'datedebut',
    ];

    protected $casts = [
        'client_id' => 'integer',
        'devis_maison_id' => 'string',
        'datedebut' => 'date'
    ];

    public static array $rules = [

    ];

    public static function insert($data){
        $id = DB::table('achat')->insertGetId([
            'client_id' => $data['client_id'],
            'devis_maison_id' => $data['devis_maison_id'],
            'datedebut' => $data['datedebut'],
        ]);
        return $id;
    }
    public function devisMaison(){
        return $this->belongsTo(DevisMaison::class,'devis_maison_id');
    }
    public function tarifAchat(){
        return $this->hasOne(TarifAchat::class,'achat_id');
    }
    public static function getPayer($achat_id){
        $result =  DB::table('montant_payer')->where('achat_id', $achat_id)->first();
        if($result){
            return $result->payer;
        }
        return 0;
    }

}
