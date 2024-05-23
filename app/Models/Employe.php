<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employe extends Model
{
    public $table = 'employe';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $fillable = [
        'id','poste_id','nom','prenoms','datenaissance'
    ];

    protected $casts = [
        'nom' => 'string',
        'prenoms' => 'string',
        'datenaissance' => 'date'
    ];

    public static array $rules = [
        'nom' => 'required|max:50|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/',
        'prenoms' => 'required|max:50|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/',
        'datenaissance' => 'required|date|before:tomorrow',
    ];

    public static $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
        'nom.regex' => 'Le nom ne peut pas accepter le caractere speciaux et le chiffre',
        'prenoms.required' => 'Le nom est obligatoire.',
        'prenoms.max' => 'Le nom est trop long.',
        'prenoms.regex' => 'Le nom ne peut pas accepter le caractere speciaux et le chiffre',
        'datenaissance.required' => 'La date de naissance est obligatoire.',
        'datenaissance.date' => 'La date de naissance doit être une date valide.',
        'datenaissance.before' => 'La date de naissance ne peut pas être dans le futur.',
    ];

    public function poste(){
        return $this->belongsTo(Poste::class,'poste_id');
    }
    public static function getId(){
        return DB::select("SELECT gen_employe_id()")[0]->gen_employe_id;
    }
}
