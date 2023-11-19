<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prive extends Model
{
    use HasFactory;
    protected $table = "prive";
    protected $primaryKey = "idprive";
    public $timestamps = false;
}
