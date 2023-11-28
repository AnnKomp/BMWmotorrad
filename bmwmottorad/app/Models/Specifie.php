<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specifie extends Model
{
    protected $table = "specifie";
    protected $primaryKey = "idmoto, idoption";
    public $timestamps = false;

    use HasFactory;
}
