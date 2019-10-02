<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

	protected $hidden = [
					        'password',
					    ];

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten');
    }
}
