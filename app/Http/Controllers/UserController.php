<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /************** function index ************** */
    /*public function inscription(Request $request){ /* $request->all(); récuperer les données de l'utilisateur, pour une méthode post puis nous les retournent en format json*/
    /*return $request->all();*/


    /*************function store ************* */
    /* Permet de créer un premier niveau de sécurité avec la validation*/
    public function inscription(Request $request)
    {
        $utilisateurDonnees = $request->validate([
            'name' => ['required', 'string', "min:2", "max:100"],
            'email' => ['required', "email", "unique:users,email"],
            'password' => ['required', 'string', 'min:4', 'max:100', 'confirmed']
        ]);

        /* Permet d'importer le modèle User, puis de spécifier les champs attendus. D'abord on initialise une variable qui stockera les données precedemment requises */
        $utilisateurs = User::create([
            "name" => $utilisateurDonnees["name"],
            "email" => $utilisateurDonnees["email"],
            "password" => bcrypt($utilisateurDonnees["password"])
        ]);
        return response($utilisateurs, 201);
    }


    /* Gestion de la connexion*/
    public function connexion(Request $request)
    {
        $utilisateurDonnees = $request->validate([
            'email' => ['required', "email"],
            'password' => ['required', 'string', 'min:4', 'max:100']
        ]);

        /* Vérification de l'email et du mot de passe, si ce dernier n'est pas enregistré dans la db alors retourner un message d'erreur*/
        $utilisateur = User::where("email", $utilisateurDonnees["email"])->first();
        if (!$utilisateur) return response(["message" => "Aucun utilisateur trouver avec l'email suivant $utilisateurDonnees[email]"], 401);
        if (!Hash::check($utilisateurDonnees["password"], $utilisateur->password)) {
            return response(["message" => "Aucun utilisateur trouver avec ce mot de passe"], 401);
        }
    //     $token = $utilisateur->createToken("CLE_SECRETE")->plainTextToken;
    //     return response([
    //         'utilisateur' => $utilisateur,
    //         'token' => $token
    //     ], 200);
    }
}
