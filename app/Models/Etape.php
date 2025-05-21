<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;
    protected $fillable = [
        'preparation_id',
        'numero',
        'description',
       
    ];

    public function preparation()
    {
        return $this->belongsTo(Preparation::class);
    }

}
