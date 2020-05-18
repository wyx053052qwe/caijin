<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info';
    protected $primaryKey = "i_id";
    public $timestamps = false;
}
