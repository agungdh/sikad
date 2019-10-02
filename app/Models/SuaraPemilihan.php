<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuaraPemilihan extends Model
{
    protected $table = 'suara_pemilihan';
    public $timestamps = false;

    public function pemilihan()
    {
        return $this->belongsTo('App\Models\Pemilihan', 'id_pemilihan');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan');
    }

    public function detilSuaras()
    {
        return $this->hasMany('App\Models\DetilSuaraPemilihan', 'id_suara_pemilihan');
    }

}
