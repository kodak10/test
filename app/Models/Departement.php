<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle'
    ];

    public function secteurs()
    {
        return $this->hasMany(Secteur::class);
    }

}
