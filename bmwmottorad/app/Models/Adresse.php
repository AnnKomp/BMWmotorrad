<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{

    protected $fillable = [
        'nompays',
        'adresse'
    ];
    use HasFactory;
    protected $table = "adresse";
    protected $primaryKey = "numadresse";
    public $timestamps = false;
}
