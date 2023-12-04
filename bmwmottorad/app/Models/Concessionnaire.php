<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionnaire extends Model
{
    use HasFactory;
    protected $table = "concessionnaire";
    protected $primarKey = "idconcessionnaire";
    public $timestamps = false;
    
}
