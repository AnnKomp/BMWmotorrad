<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infocb extends Model
{
    use HasFactory;
    protected $table = "infocb";
    protected $primaryKey = "idcarte";
    public $timestamps = false;
}
