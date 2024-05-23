<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistreRequest;
use App\Models\Client;
use App\Models\DetailDevis;
use App\Models\DevisMaison;
use App\Models\Maison;
use App\Models\Poste;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function registre(){
        return view('auth.registre');
    }
    public function inscription(RegistreRequest $request){
        $data = array(
            'nom' => $request->nom,
            'prenoms' => $request->prenoms,
            'contact' =>$request->contact,
            'email' => $request->email,
            'password' =>$request->password,
            'profil' => 1
        );
        User::insert($data);
        return redirect()->route('login');
    }
    public function home()
    {
        return redirect()->route('maisons.index');
    }
    public function se_login(LoginRequest $request){
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->profil && $user->profil->id == 1){
                return redirect()->route('devis');
            }
        }
        return back()->withErrors([
            'password' => 'Identifiant Invalid',
        ])->withInput();
    }

    public function deconnexion(){
        session()->flush();
        Auth::logout();
        return redirect()->route('loadClient');
    }
    public function loadClient(){

        return view('auth.loginClient');
    }
    public function se_login_client(CreateClientRequest $request){
        $numero = $request->numero;
        $formattedInput = ltrim($numero, '0');
        $client = Client::where('numero', $numero)->first();
        if($client){
            $request->session()->regenerate();
            Session::put('client_id', $client->id);
            return redirect()->route('travaux');
        }
        return back()->withErrors([
            'numero' => "Cette numero n'avait pas un compte",
        ])->withInput();
    }
    public function reinitialiser(){
        Maison::reinitialiser();
        return redirect()->route('loadClient');
    }
}
