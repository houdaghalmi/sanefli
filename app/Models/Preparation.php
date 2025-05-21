<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preparation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_recette',
        'quantity',
        'temps_de_preparation',
        'description',
        'nombre_etapes',
    ];

    public function recette()
    {
        return $this->belongsTo(Recette::class, 'id_recette');
    }

  
     public function etapes()
    {
        return $this->hasMany(Etape::class)->orderBy('numero');
    }

}
