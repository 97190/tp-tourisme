<?php

namespace App\Http\Controllers;

use App\Models\Loisir;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;


class LoisirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loisirs = DB::table('loisir')
         ->join('lieux', 'lieux.id', '=', 'loisir.lieu_id')
         ->get()
         ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $loisirs
        ]);
    }
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loisirValidation = $request->validate([
            "nom_loisir" => ["required", "string", "max:100"],
            "description_loisir" => ["required", "string", "max:100"],
        ]);

        $loisir = Loisir::create([
            "nom_loisir" => $request->nom_loisir,
            "description_loisir" => $request->description_loisir,
            "lieu_id" => $request->lieu_id,
        ]);
        return response()->json([
            "status" => "Succes",
            'data' => $loisir,
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loisir  $loisir
     * @return \Illuminate\Http\Response
     */
    public function show(Loisir $loisir)
    {
        return  response()->json($loisir);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loisir  $loisir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loisir $loisir)
    {
        $loisirValidation = $request->validate([
            "nom_loisir" => ["string", "max:100"],
            "description_loisir" => ["string", "max:100"],
        ]);
        
        $loisir->update([
            "nom_loisir" => $request->nom_loisir,
            "description_loisir" => $request->description_loisir,
            "lieu_id" => $request ->lieu_id,
        ]);
        return response()->json([
            'status' => 'Mise à jour réussi'
        ]);
    }
/**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loisir  $loisir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loisir $loisir)
    {
        $loisir->delete();

        return response()->json([
            "status" => "Supprimer avec succès"
        ]);
    }
}
