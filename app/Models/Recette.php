<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_category', 'image', 'description', 'difficulty', 'servings', 'preparation_time'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // Change from preparations() to preparation() since it's a one-to-one relationship
    public function preparation()
    {
        return $this->hasOne(Preparation::class, 'id_recette');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recette');
    }

    public function notations()
    {
        return $this->hasMany(Notation::class, 'id_recette');
    }

    public function favoris()
    {
        return $this->hasMany(Fav::class, 'id_recette');
    }

    public function getPreparationTime()
    {
        return $this->preparation ? $this->preparation->temps_de_preparation : $this->preparation_time;
    }

    public function isFavoritedBy($userId)
    {
        return $this->favoris()->where('id_user', $userId)->exists();
    }
}