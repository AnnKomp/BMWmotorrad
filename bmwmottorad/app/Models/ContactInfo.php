<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = [
        'nomcontact',
        'prenomcontact',
        'datenaissancecontact',
        'emailcontact',
        'telcontact',
    ];
    use HasFactory;
    protected $table = "contactinfo";
    protected $primaryKey = "idcontact";
    public $timestamps = false;
}
