<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    public $table = 'client';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public $fillable = [
        'numero'
    ];

    protected $casts = [
    ];

    public static $rules = [
        'numero' => 'required|size:10|regex:/^[0-9]+$/',
    ];


    public static $messages = [
        'numero.required' => 'Le numéro est obligatoire.',
        'numero.size' => 'Le numéro doit avoir exactement 10 caractères.',
        'numero.regex' => 'Le numéro doit être un numero telephone.',
    ];
    public static function getBynumero($numero){
        $result = DB::select("SELECT id FROM client WHERE numero =?", [$numero]);
        return $result[0]->id?? null;
    }

}
