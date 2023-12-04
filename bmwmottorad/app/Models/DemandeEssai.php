<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeEssai extends Model
{
    use HasFactory;
    protected $table = "demandeessai";
    protected $primaryKey = "iddemandessai";
    public $timestamps = false;
}
