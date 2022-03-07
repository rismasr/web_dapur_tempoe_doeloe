<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "groups";
    protected $primaryKey = 'id';
    protected $fillable = ['name','created_at','updated_at'];

    public function contoh()
    {
        return $this->hasOne('App\User');
    }
}
