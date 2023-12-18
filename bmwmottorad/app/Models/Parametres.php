<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametres extends Model
{
    use HasFactory;
    protected $table = 'parametres';
    protected $primaryKey = 'nomparametre';
    public $timestamps = false;
}
