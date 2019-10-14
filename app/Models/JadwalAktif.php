<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalAktif extends Model
{
    protected $table = 'jadwal_aktif';
    public $timestamps = false;

    public function jadwal()
    {
        return $this->belongsTo('App\Models\Jadwal', 'id_jadwal');
    }

    public function mahasiswa()
    {
        return $this->belongsTo('App\Models\Mahasiswa', 'id_mahasiswa');
    }
}
