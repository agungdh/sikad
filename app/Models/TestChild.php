<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestChild extends Model
{
    protected $table = 'testchild';
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo('App\Models\Child', 'id_test');
    }
}
