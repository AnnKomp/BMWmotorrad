<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taille extends Model
{
    protected $table = "taille";
    protected $primaryKey = "idtaille";
    public $timestamps = false;

    use HasFactory;
}
