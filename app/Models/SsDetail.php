<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsDetail extends Model
{
    public $table = 'ss_detail';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'detail_devis_id',
        'detail_travail_id',
        'quantite',
        'pu'
    ];

    protected $casts = [
        'detail_devis_id' => 'integer',
        'detail_travail_id' => 'integer',
    ];

    public static array $rules = [

    ];
    public function detailDevis(){
        return $this->belongsTo(DetailDevis::class,'detail_devis_id');
    }
    public function detailTravail(){
        return $this->belongsTo(DetailTravail::class,'detail_travail_id');
    }

}
