<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_category','image'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

   public function preparations()
{
    return $this->hasMany(Preparation::class, 'id_recette');
}

    public function notations()
    {
        return $this->hasMany(Notation::class, 'id_recette');
    }

    public function favoris()
    {
        return $this->hasMany(Fav::class, 'id_recette');
    }
public function ingredients()
{
    return $this->belongsToMany(Ingredient::class, 'ingredient_recette');
}


}
