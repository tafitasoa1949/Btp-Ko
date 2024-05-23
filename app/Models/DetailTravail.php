<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTravail extends Model
{
    public $table = 'detail_travail';

    public $fillable = [
        'travail_id',
        'unite_travail_id',
        'nom',
        'pu'
    ];

    protected $casts = [
        'travail_id' => 'integer',
        'unite_travail_id' => 'integer',
        'nom' => 'string',
        'pu' => 'double'
    ];

    public static array $rules = [

    ];
    public function ssDetail(){
        return $this->hasMany(SsDetail::class,'detail_travail_id');
    }
    public function unite(){
        return $this->belongsTo(Unite::class,'unite_travail_id');
    }

}
