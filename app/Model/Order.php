<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = "o_id";
    public $timestamps = false;
    protected $fillable = [

    ];
}
