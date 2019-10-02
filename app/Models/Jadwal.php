<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    public $timestamps = false;

    public function matkul()
    {
        return $this->belongsTo('App\Models\Matkul', 'id_matkul');
    }

    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
