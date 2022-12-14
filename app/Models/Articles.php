<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $fillable = [
        "title", "body", "user_id", "image_path", "theme_id", "loisir_id"
    ];
}
