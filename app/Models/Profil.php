<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'profil';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nom',
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
}
