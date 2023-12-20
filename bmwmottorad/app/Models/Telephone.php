<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $fillable = [
        'numtelephone',
        'fonction',
        'type',
        'idclient'
    ];
    use HasFactory;
    protected $table = "telephone";
    protected $primaryKey = "idtelephone";
    public $timestamps = false;
}
