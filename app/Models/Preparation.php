<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_recette',
        'id_ingredient',
        'quantity',
        'temps_de_preparation',
        'description'
    ];

    public function recette()
    {
        return $this->belongsTo(Recette::class, 'id_recette');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'id_ingredient');
    }
}
