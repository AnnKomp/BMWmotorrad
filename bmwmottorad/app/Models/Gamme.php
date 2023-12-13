<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamme extends Model
{
    protected $table = "gammemoto";
    protected $primaryKey = "idgamme";
    public $timestamps = false;
    use HasFactory;
}
