<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenucommande extends Model
{
    use HasFactory;
    protected $table = "contenucommande";
    protected $primaryKey = "idcommande";
    public $timestamps = false;
}
