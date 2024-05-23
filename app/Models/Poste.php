<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Poste extends Model
{
    public $table = 'poste';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $fillable = [
        'id',
        'nom'
    ];

    protected $casts = [
        'nom' => 'string'
    ];

    public static array $rules = [
        'nom' => 'required|min:4|max:50|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/',
    ];

    public static $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
        'nom.min' => 'Le nom est trop court.',
        'nom.regex' => 'Le nom ne peut pas accepter le caractere speciaux et le chiffre',
    ];
    public static function getId(){
        return DB::select("SELECT gen_poste_id()")[0]->gen_poste_id;
    }

    public function employes(){
        return $this->hasMany(Employe::class,'poste_id');
    }
}
