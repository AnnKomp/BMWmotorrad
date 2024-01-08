<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieAccessoire extends Model
{
     protected $table = "categorieaccessoire";
    protected $primaryKey = "idcatacc";
    public $timestamps = false;

    use HasFactory;
}
