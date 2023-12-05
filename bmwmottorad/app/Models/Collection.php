<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';
    protected $primaryKey = 'idcollection';
    protected $fillable = ['nomcollection'];

    use HasFactory;
}
