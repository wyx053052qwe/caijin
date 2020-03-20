<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cz extends Model
{
    protected $table = 'cz';
    protected $primaryKey = "c_id";
    public $timestamps = false;
    protected $mapping = [
        '*'
    ];


}
