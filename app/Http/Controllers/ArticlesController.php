<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::table("articles")
        ->join("themes", "themes.id", '=', "articles.theme_id", "loisirs", "loisirs.id", '=', "articles.loisir_id")
        ->get()
        ->toArray();

        return response()->json([
            'status' => "Succès",
            "data" => $articles,
        ]);
        // $articles = Articles::all();
        // return $articles;
        // if (count($articles) <= 0) {
        //     return response(["message" => "Aucun n'article de disponible"], 204);
        // }
        // return response($articles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articlesValidation = $request->validate([
            "title" => ["required", "string", "max:100"],
            "body" => ["required", "string", "max:500"],
            "image_path"=> ["required", "mimes:png,jpeg,jpg", "max:4096"],
            "user_id" => ["required", "numeric"],
        ]);

/* Enregistre l'image dans le dossier public/images */ 
        $path = $request->file("image_path")->store("public/images");

        $articles = Articles::create([
            "title" => $articlesValidation["title"],
            "body" => $articlesValidation["body"],
            "image_path" => $path,
            "user_id" => $articlesValidation["user_id"],
            "theme_id" => $request->theme_id,
            "loisir_id" => $request->loisir_id,
            
            
        ]);
        return response(["Article ajouté"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articles = DB::table("articles")
            ->join("users", "articles.user_id", "=", "users.id")
            ->select("articles.*", "users.name", "users.email")
            ->where("articles.id", "=", $id)
            ->get()
            ->first();
        return $articles;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $articlesValidation = $request->validate([
            "title" => ["string", "max:100"],
            "body" => ["string", "max:500"],
            "user_id" => ["required", "numeric"],
            //"photoArticle"=> ["required", "string"],
        ]);

        $articles = Articles::find($id);
        if (!$articles) {
            return response(["message" => "Pas d'article trouvé avec cet id $id"], 404);
        }
        if ($articles->user_id !=  $articlesValidation["user_id"]) {
            return response(["message" => "Action interdite"], 403);
        }
        $articles->update([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user_id,
            'theme_id' => $request->theme_id,
            'loisir_id' => $request->loisir_id,
        ]);
        return response(["message" => "Article mis à jour"], 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $articlesValidation = $request->validate([
            "user_id" => ["required", "numeric"],
        ]);
        $articles = Articles::find($id);
        if (!$articles) {
            return response(["message" => "Pas d'article trouvé avec cet id $id"], 404);
        }
        if ($articles->user_id !=  $articlesValidation["user_id"]) {
            return response(["message" => "Action interdite"], 403);
        }
        $value = Articles::destroy($id);
        if (boolval($value) === false) {
            return response(["message" => "Aucun article trouvé avec cet id $id"], 404);
        }
        return response(["message" => "Article supprimé"], 202);
    }
}
