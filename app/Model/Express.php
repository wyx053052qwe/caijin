<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{
    protected $table = 'express';
    protected $primaryKey = "e_id";
    public $timestamps = false;
    protected $mapping = [
        '*'
    ];
}
