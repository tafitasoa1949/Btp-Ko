<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDevis extends Model
{
    public $table = 'detail_devis';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'devis_maison_id',
        'compte_id',
        'quantite',
        'pu'
    ];

    protected $casts = [
        'compte_devis_maison_id' => 'integer',
        'travail_id' => 'integer',
    ];

    public static array $rules = [

    ];
    public function compte(){
        return $this->belongsTo(Compte::class,'compte_id');
    }
}
