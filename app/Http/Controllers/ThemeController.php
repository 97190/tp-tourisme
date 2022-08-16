<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $themes = Theme::all();
        return response()->json($themes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $themeValidation = $request->validate([
            "nom_theme" => ["required", "string", "max:100"],
            "developpement_theme" => ["required", "string", "max:100"],
        ]);

        $theme = Theme::create([
            "nom_theme" => $request->nom_theme,
            "developpement_theme" => $request->developpement_theme,
        ]);
        return response()->json([
            "status" => "Succes",
            'data' => $theme,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        return  response()->json($theme);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $theme)
    {
        $themeValidation = $request->validate([
            "nom_theme" => ["string", "max:100"],
            "developpement_theme" => ["string", "max:100"],
        ]);
        
        $theme->update([
            "nom_theme" => $request->nom_theme,
            "developpement_theme" => $request->developpement_theme,
        ]);
        return response()->json([
            'status' => 'Mise à jour réussi'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return response()->json([
            "status" => "Supprimer avec succès"
        ]);
    }
}
