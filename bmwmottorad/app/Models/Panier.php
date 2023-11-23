<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $table = "panier";
    protected $primaryKey = "idpanier";
    public $timestamps = false;
    use HasFactory;
}
