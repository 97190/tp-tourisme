<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loisir extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom_loisir", "description_loisir"
    ];
}
