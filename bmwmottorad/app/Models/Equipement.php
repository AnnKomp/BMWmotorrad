<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{

    protected $table = "equipement";
    protected $primaryKey = "idequipement";
    public $timestamps = false;
    protected $keyType = 'integer';


    protected $fillable = [
        'prixequipement',
        // Add other fillable attributes as needed
    ];

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(CategorieEquipement::class, 'idcategorieequipement');
    }
}
