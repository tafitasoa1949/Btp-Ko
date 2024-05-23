<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    public $table = 'compte';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'maison_id',
        'code',
        'nom',
        'unite_id',
        'quantite',
        'pu'
    ];

    protected $casts = [
        'code' => 'string',
        'nom' => 'string'
    ];

    public static array $rules = [
        'code' => 'required',
        'nom' => 'required',
    ];
    public static $messages = [
        'code.required' => 'Le code est obligatoire.',
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
    ];
    public function unite(){
        return $this->belongsTo(Unite::class,'unite_id');
    }
}
