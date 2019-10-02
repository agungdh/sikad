<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    public $timestamps = false;

    public function childs()
    {
        return $this->hasMany('App\Models\TestChild', 'id_test');
    }
}
