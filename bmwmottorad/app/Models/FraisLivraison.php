<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisLivraison extends Model
{
    protected $table = "parametres";
    protected $primaryKey = "nomparametre";
    public $timestamps = false;

    protected $fillable = ['description'];

    use HasFactory;
}
