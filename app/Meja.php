<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = "meja";
    protected $primaryKey = 'id';
    protected $fillable = ['no','created_at','updated_at'];
}
