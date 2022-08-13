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
        $articles = Articles::all();
        return $articles;
        if (count($articles) == -0) {
            return response(["message" => "Aucun n'article de disponible"], 204);
        }
        return response($articles, 200);
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
            "title" => ["required", "string"],
            "body" => ["required", "string", "max:500"],
            "user_id" => ["required", "numeric"]
            //"photoArticle"=> ["required", "string"],
        ]);

        $articles = Articles::create([
            "title" => $articlesValidation["title"],
            "body" => $articlesValidation["body"],
            "user_id" => $articlesValidation["user_id"],
            //"photoArticle"=> ["required", "string"],
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
            "title" => ["string"],
            "body" => ["string", "max:500"],
            "user_id" => ["required", "numeric"],
            //"photoArticle"=> ["required", "string"],
        ]);

        $articles = Articles::find($id);
        if (!$articles) {
            return response(["message" => "Pas d'article trouvé avec cet id $id"], 404);
        }
        if (!$articles->user_id ===  $articlesValidation["user_id"]) {
            return response(["message" => "Action interdite"], 403);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Articles  $articles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articles $articles)
    {
        //
    }
}
