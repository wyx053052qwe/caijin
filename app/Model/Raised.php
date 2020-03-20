<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Raised extends Model
{
    protected $table = 'raised';
    protected $primaryKey = "r_id";
    public $timestamps = false;
    protected $fillable = [

    ];
}
