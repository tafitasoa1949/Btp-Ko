<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifAchat extends Model
{
    public $table = 'tarif_achat';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'achat_id',
        'finition_id',
        'prix_finition',
        'pourcentage',
        'montant_total'
    ];

    protected $casts = [
        'achat_id' => 'integer',
        'finition_id' => 'integer',
        'pourcentage' => 'string',
        'prix_finition' => 'string',
        'montant_total' => 'string'
    ];

    public static array $rules = [

    ];
    public function finition(){
        return $this->belongsTo(Finition::class,'finition_id');
    }
    public function achat(){
        return $this->belongsTo(Achat::class,'achat_id');
    }

}
