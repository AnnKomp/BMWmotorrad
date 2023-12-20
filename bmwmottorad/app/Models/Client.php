<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'civilite',
        'nomclient',
        'prenomclient',
        'datenaissanceclient',
        'emailclient',
        'numadresse',
    ];
    use HasFactory;
    protected $table = "client";
    protected $primaryKey = "idclient";
    public $timestamps = false;
}
