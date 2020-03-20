<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'upload';
    protected $primaryKey = "p_id";
    public $timestamps = false;
}
