<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travail extends Model
{
    public $table = 'travail';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'compte_id',
        'unite_travail_id',
        'code',
        'nom',
        'pu'
    ];

    protected $casts = [
        'compte_id' => 'integer',
        'unite_travail_id' => 'integer',
        'code' => 'string',
        'nom' => 'string',
        'pu' => 'double',
    ];

    public static array $rules = [
        'code' => 'required',
        'nom' => 'required|max:50',
        'pu' => 'required'
    ];
    public static $messages = [
        'code.required' => 'Le code est obligatoire.',
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
        'pu.regex' => 'regex',
    ];

    public function compte(){
        return $this->belongsTo(Compte::class,'compte_id');
    }
    public function unite(){
        return $this->belongsTo(Unite::class,'unite_travail_id');
    }
}
