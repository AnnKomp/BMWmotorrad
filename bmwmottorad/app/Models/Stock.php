<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "stock";
    protected $primaryKey = ['idequipement', 'idtaille', 'idcoloris'];
    public $timestamps = false;
    public $incrementing = false; // Indique que la clé primaire n'est pas auto-incrémentée

    protected $fillable = ['idequipement', 'idtaille', 'idcoloris', 'quantite'];

    use HasFactory;
}
