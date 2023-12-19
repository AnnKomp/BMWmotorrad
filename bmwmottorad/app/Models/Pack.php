<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{

    protected $table = "pack";
    protected $primaryKey = "idpack";
    protected $fillable = ['idpack','idmoto','nompack','descriptionpack','photopack','prixpack'];
    public $timestamps = false;
    use HasFactory;
}
