<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    
    protected $table = "option";
    protected $primaryKey = "idoption";
    public $timestamps = false;
    use HasFactory;
}
