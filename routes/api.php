<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("/utilisateur/inscription", [UserController::class, "inscription"]);
Route::post("/utilisateur/connexion", [UserController::class, "connexion"]);

Route::get("/articles", [ArticlesController::class, "index" ]);
Route::post("/articles", [ArticlesController::class, "store" ]);
Route::get("/articles/{id}", [ArticlesController::class, "show" ]);
Route::put("/articles/{id}", [ArticlesController::class, "update" ]);
Route::delete("/articles/{id}", [ArticlesController::class, "destroy" ]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
