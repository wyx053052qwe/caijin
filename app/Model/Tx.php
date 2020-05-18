<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tx extends Model
{
    protected $table = 'tx';
    protected $primaryKey = "t_id";
    public $timestamps = false;
}
