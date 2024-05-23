<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Finition extends Model
{
    public $table = 'finition';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'nom',
        'pourcentage'
    ];

    protected $casts = [
    ];

    public static array $rules = [
        'nom' => 'required|max:50|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/',
        'pourcentage' => 'required|numeric|min:0'
    ];
    public static $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
        'nom.regex' => 'Le nom ne peut pas accepter le caractere speciaux et le chiffre',
        'pourcentage.required' => 'Le surface est obligatoire.',
        'pourcentage.min' => 'Le surface doit être positif.',
    ];
    public static function getByNom($nom){
        $result = DB::select("SELECT id FROM finition WHERE nom =?", [$nom]);
        return $result[0]->id?? null;
    }

}
