<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    use HasFactory;

    public function packs()
    {
        return $this->hasMany(Pack::class, 'idmoto', 'idmoto');
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'specifie', 'idmoto', 'idoption');
    }

    public function accessoires()
    {
        return $this->hasMany(Accessoire::class, 'idmoto', 'idmoto');
    }

    protected $table = "modelemoto";
    protected $primaryKey = "idmoto";
    public $timestamps = false;
}
