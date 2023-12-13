<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristique extends Model
{
    protected $table = "caracteristique";
    protected $primaryKey = "idcaracteristique";
    public $timestamps = false;
    use HasFactory;
}
