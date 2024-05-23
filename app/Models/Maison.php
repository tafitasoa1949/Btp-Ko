<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;

class Maison extends Model
{
    public $table = 'maison';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'nom',
        'surface',
        'detail',
        'duree'
    ];

    protected $casts = [
        'nom' => 'string'
    ];

    public static array $rules = [
        'nom' => 'required|max:50|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/',
        'surface' => 'required|numeric|min:20',
        'duree' => 'required|numeric|min:10'
    ];
    public static $messages = [
        'nom.required' => 'Le nom est obligatoire.',
        'nom.max' => 'Le nom est trop long.',
        'nom.regex' => 'Le nom ne peut pas accepter le caractere speciaux et le chiffre',
        'surface.required' => 'Le surface est obligatoire.',
        'surface.min' => 'Le surface doit être superieur à 20.',
        'duree.required' => 'Le surface est obligatoire.',
        'duree.min' => 'Le surface doit être superieur à 10.',
    ];

    public function comptes()
    {
        return $this->hasMany(Compte::class, 'maison_id');
    }
    public function devisMaison()
    {
        return $this->hasMany(DevisMaison::class, 'maison_id');
    }
    public function details(){
        return $this->hasMany(DetailMaison::class,'maison_id');
    }
    public static function checkNombre($nombre) {
        // Expression régulière pour vérifier si le nombre contient des caractères spéciaux
        // Ajout de la possibilité d'avoir un point dans le nombre
        $pattern = '/[^a-zA-Z0-9.\sàâäèéêëïîôöùûüÀÂÄÈÉÊËÏÎÔÖÙÛÜ]/';
        if (preg_match($pattern, $nombre)) {
            return false; // Contient des caractères spéciaux
        }

        // Vérification pour s'assurer que le nombre est positif
        if ($nombre < 0) {
            return false; // Nombre négatif ou zéro
        }

        return true; // Nombre valide
    }
    public static function checkDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $date_errors = DateTime::getLastErrors();
        if ($date_errors['warning_count'] || $date_errors['error_count']) {
            return false;
        }
        return true;
    }
    public static function getId(){
        return DB::select("SELECT gen_maison_id()")[0]->gen_maison_id;
    }
    public static function insert($data){
        $maison = new Maison();
        $maison->id = Maison::getId();
        $maison->nom = $data['nom'];
        $maison->surface = $data['surface'];
        $maison->save();
    }
    public static function splitPhrase($phrase) {
        $tableau = explode(',', $phrase);
        return $tableau;
    }
    public static function reinitialiser(){
        DB::select("select re()");
    }
    public static function generateMaison(){
        DB::select("select generate_maison()");
    }
    public static function generate_unite(){
        DB::select("select generate_unite()");
    }
    public static function generate_client(){
        DB::select("select generate_client()");
    }
    public static function generate_finition(){
        DB::select("select generate_finition()");
    }

    public static function generateDetail(){
        $maisons = Maison::all();
        foreach ($maisons as $m){
            $tableau = self::splitPhrase($m->detail);
            foreach ($tableau as $desc){
                $details = new DetailMaison();
                $details->maison_id = $m->id;
                $details->description = $desc;
                $details->save();
            }
        }
    }
    public static function generateCompte(){
        $maisons = Maison::all();
        foreach ($maisons as $m) {
            $comptes = DB::select("SELECT code, nomcode, unite, pu, quantite FROM csv_maison WHERE maison =?", [$m->nom]);
            if(!empty($comptes)){
                foreach ($comptes as $c) {
                    $konty = new Compte();
                    $konty->maison_id = $m->id;
                    $konty->code = $c->code;
                    $konty->nom = $c->nomcode;
                    $konty->unite_id = Unite::where('nom', $c->unite)->first()->id;
                    $konty->quantite = $c->quantite;
                    $konty->pu = $c->pu;
                    $konty->save();
                }
            }
        }
    }
    public static function getByNom($nom){
        $result = DB::select("SELECT id FROM maison WHERE nom =?", [$nom]);
        return $result[0]->id?? null;
    }
    public static function ajouterJours($date, $nombreDeJours) {
        // Créer un objet DateTime à partir de la date donnée
        $dateObj = new DateTime($date);

        // Ajouter le nombre de jours à l'objet DateTime
        $dateObj->modify("+{$nombreDeJours} days");

        // Afficher la nouvelle date
        return  $dateObj->format('Y-m-d');
    }
    function compareDates($date1, $date2) {
        // Création des instances Carbon à partir des chaînes de caractères avec le format Y-d-m
        $date1Instance = Carbon::createFromFormat('Y-d-m', $date1);
        $date2Instance = Carbon::createFromFormat('Y-d-m', $date2);

        // Comparaison des dates
        if ($date1Instance->lt($date2Instance)) {
            return "La date $date1 est antérieure à la date $date2";
        } elseif ($date1Instance->gt($date2Instance)) {
            return "La date $date1 est postérieure à la date $date2";
        } else {
            return "Les deux dates sont égales";
        }
    }
    public static function getIntervalInHours($datetime1, $datetime2) {
        $interval = $datetime1->diff($datetime2);
        $totalHours = $interval->days * 24 + $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;
        $minutes += floor($seconds / 60);
        $totalHours += $minutes / 60;
        $minutes %= 60;
        $formattedHours = number_format($totalHours, 2);
        return $formattedHours;
    }
    public static function getIntervalHeureMinSec($datetime1, $datetime2) {
        $interval = $datetime1->diff($datetime2);
        $totalHours = $interval->days * 24 + $interval->h;
        $totalMinutes = $interval->i;
        $totalSeconds = $interval->s;
        while ($totalMinutes >= 60) {
            $totalHours++;
            $totalMinutes -= 60;
        }
        while ($totalSeconds >= 60) {
            $totalMinutes++;
            $totalSeconds -= 60;
        }
        $formattedDuration = sprintf("%02d:%02d:%02d", $totalHours, $totalMinutes, $totalSeconds);
        return $formattedDuration;
    }


}
