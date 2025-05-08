<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;
    protected $fillable = ['id_user', 'id_recette', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function recette()
    {
        return $this->belongsTo(Recette::class, 'id_recette');
    }
}
