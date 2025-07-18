<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image'];

public function recettes()
{
    return $this->belongsToMany(Recette::class, 'ingredient_recette');
             
}

}
