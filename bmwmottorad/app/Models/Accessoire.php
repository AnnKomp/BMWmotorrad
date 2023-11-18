<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessoire extends Model
{
    
    protected $table = "accessoire";
    protected $primaryKey = "idaccessoire";
    public $timestamps = false;
    use HasFactory;
}
