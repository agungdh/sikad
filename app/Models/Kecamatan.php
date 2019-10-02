<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    public $timestamps = false;

    public function kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'id_kabupaten');
    }
}
