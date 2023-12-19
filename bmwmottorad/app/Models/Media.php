<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'idmedia';
    protected $fillable = ['idequipement','idmoto','lienmedia','lienpresentation'];
    public $timestamps = false;
    use HasFactory;
}
