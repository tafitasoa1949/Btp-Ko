<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMaison extends Model
{
    public $table = 'detail_maison';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'maison_id',
        'description'
    ];

    protected $casts = [
        'maison_id' => 'string',
        'description' => 'string'
    ];

    public static array $rules = [
        'description' => 'required|max:255',
    ];
    public static $messages = [
        'description.required' => 'Le description est obligatoire.',
        'description.max' => 'Le description doite etre inferieur 255 caracteres.',
    ];
    public function maison(){
        return $this->belongsTo(Maison::class,'maison_id');
    }


}
