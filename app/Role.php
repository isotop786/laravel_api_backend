<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // protected $table = "roles";
    // protected $primary_key = "id";
    
    protected $guarded = ['id'];

    public $timestamps = false;

}
