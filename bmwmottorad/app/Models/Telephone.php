<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    use HasFactory;
    protected $table = "telephone";
    protected $primaryKey = "numtelephone";
    public $timestamps = false;
}
