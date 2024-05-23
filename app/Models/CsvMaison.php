<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvMaison extends Model
{
    use HasFactory;
    public $table = 'csv_maison';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $fillable = [
        'id',
        'maison',
        'description',
        'surface',
        'code',
        'nomcode',
        'unite',
        'pu',
        'quantite',
        'duree'
    ];
    public static function insert($data){
        $csvMaison = new CsvMaison();
        $csvMaison->maison = $data['maison'];
        $csvMaison->description = $data['description'];
        $csvMaison->surface = $data['surface'];
        $csvMaison->code = $data['code'];
        $csvMaison->nomcode = $data['nomcode'];
        $csvMaison->unite = $data['unite'];
        $csvMaison->pu = $data['pu'];
        $csvMaison->quantite = $data['quantite'];
        $csvMaison->duree = $data['duree'];
        $csvMaison->save();
    }

}
