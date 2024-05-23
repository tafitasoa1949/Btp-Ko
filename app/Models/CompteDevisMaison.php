<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteDevisMaison extends Model
{
    public $table = 'compte_devis_maison';

    public $fillable = [
        'devis_maison_id',
        'compte_id'
    ];

    protected $casts = [
        'devis_maison_id' => 'integer',
        'compte_id' => 'integer'
    ];

    public static array $rules = [

    ];
    public function devisMaison(){
        return $this->belongsTo(DevisMaison::class,'devis_maison_id');
    }
    public function compte(){
        return $this->belongsTo(Compte::class,'compte_id');
    }
    public function detail_devis(){
        return $this->hasMany(DetailDevis::class,'compte_devis_maison_id');
    }

}
