<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{

    protected $table = "equipement";
    protected $primaryKey = "idequipement";
    public $timestamps = false;


    use HasFactory;
}
