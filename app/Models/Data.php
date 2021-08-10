<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'email', 'image', 'gender', 'skills'];

    // public function setDataAttribute($value)
    // {
    //     return $this->attributes['skills'] = json_encode($value);
    // }

    // public function getDataAttribute($value)
    // {
    //     return $this->attributes['skills'] = json_decode($value);
    // }
}
