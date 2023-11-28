<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieEquipement extends Model
{
    protected $table = 'categorieequipement';
    protected $primaryKey = 'idcatequipement';
    protected $fillable = ['libellecatequipement'];

    use HasFactory;
}
