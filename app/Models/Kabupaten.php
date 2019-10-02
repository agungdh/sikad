<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';
    public $timestamps = false;

    public function kecamatans()
    {
        return $this->hasMany('App\Models\Kecamatan', 'id_kabupaten');
    }
}
