<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = "c_id";
    public $timestamps = false;
    protected $mapping = [
        '*'
    ];
}