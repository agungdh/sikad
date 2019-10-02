<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetilSuaraPemilihan extends Model
{
    protected $table = 'detil_suara_pemilihan';
    public $timestamps = false;

    public function suara()
    {
        return $this->belongsTo('App\Models\SuaraPemilihan', 'id_suara_pemilihan');
    }

    public function partai()
    {
        return $this->belongsTo('App\Models\Partai', 'id_partai');
    }

    public function paslonCapres()
    {
        return $this->belongsTo('App\Models\PaslonCapres', 'id_paslon_capres');
    }

    public function calonDPD()
    {
        return $this->belongsTo('App\Models\CalonDPD', 'id_calon_dpd');
    }

}
