<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    public $table = 'unite';

    public $fillable = [
        'nom'
    ];

    protected $casts = [
        'nom' => 'string'
    ];

    public static array $rules = [

    ];

}
