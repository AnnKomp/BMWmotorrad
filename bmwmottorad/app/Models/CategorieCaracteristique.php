<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieCaracteristique extends Model
{
    protected $table = "categoriecaracteristique";
    protected $primaryKey = "idcatcaracteristique";
    public $timestamps = false;
    use HasFactory;
}
