<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Pemilihan;
use App\Models\SuaraPemilihan;
use App\Models\Kecamatan;

use ADHhelper;

use DB;
use Validator;

class SuaraController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:pemilihan');
    }

    public function getUserKabupatenKecamatan()
    {
        return $this->getKecamatans(ADHhelper::getUsersKecamatan());
    }

    public function getUserProvinsiKecamatan()
    {
        return $this->getKecamatans(Kecamatan::all());
    }

    public function getKecamatans($kecamatans)
    {
        $kecamatans_raw = $kecamatans;
        $kecamatans = [];
        foreach ($kecamatans_raw as $item) {
            $kecamatans[$item->id] = "{$item->kecamatan}";
        }

        return $kecamatans;
    }

    public function index($id_pemilihan)
    {
        if(ADHhelper::getUserData()->level == 'opkab') {
            $kecamatansWhere = [];
            foreach (ADHhelper::getUsersKecamatan() as $item) {
                $kecamatansWhere[] = $item->id;
            }
            
            $pemilihan = Pemilihan::find($id_pemilihan);
            $suaras = SuaraPemilihan::with('kecamatan', 'detilSuaras')->whereIn('id_kecamatan', $kecamatansWhere)->where('id_pemilihan', $id_pemilihan)->get();            
        } else {
            $pemilihan = Pemilihan::with('suaras.kecamatan', 'suaras.detilSuaras')->find($id_pemilihan);
            $suaras = $pemilihan->suaras;
        }
        
        return view('suara.index', compact(['pemilihan', 'suaras']));
    }

    public function create($id_pemilihan)
    {
        $pemilihan = Pemilihan::find($id_pemilihan);
        if(ADHhelper::getUserData()->level == 'opkab') {
            $kecamatans = $this->getUserKabupatenKecamatan();
        } else {
            $kecamatans = $this->getUserProvinsiKecamatan();
        }

        return view('suara.create', compact(['pemilihan', 'kecamatans']));
    }

    public function store(Request $request, $id_pemilihan)
    {
        $validator = Validator::make($request->all(), [
            'id_kecamatan' => 'required',
            'jumlah_kelurahan' => 'required',
            'jumlah_tps' => 'required',
            'jumlah_pemilih' => 'required',
            'jumlah_suara_tidak_sah' => 'required',
        ]);

        $pemilihan = SuaraPemilihan::where([
            'id_kecamatan' => $request->id_kecamatan,
            'id_pemilihan' => $id_pemilihan,
        ])->first();

        if ($pemilihan) {
            $validator->after(function ($validator) {
                $validator->errors()->add('id_kecamatan', 'The Suara for this Kecamatan and Pemilihan already been taken.');
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = $request->only('id_kecamatan', 'jumlah_kelurahan', 'jumlah_tps', 'jumlah_pemilih', 'jumlah_suara_tidak_sah');
        $data['id_pemilihan'] = $id_pemilihan;
        $data['jumlah_kelurahan'] = str_replace(".", "", $request->jumlah_kelurahan);
        $data['jumlah_tps'] = str_replace(".", "", $request->jumlah_tps);
        $data['jumlah_pemilih'] = str_replace(".", "", $request->jumlah_pemilih);
        $data['jumlah_suara_tidak_sah'] = str_replace(".", "", $request->jumlah_suara_tidak_sah);

        DB::table('suara_pemilihan')->insert($data);
       
        return redirect()->route('suara.index', $id_pemilihan)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $suara = SuaraPemilihan::find($id);
        $pemilihan = $suara->pemilihan;
        if(ADHhelper::getUserData()->level == 'opkab') {
            $kecamatans = $this->getUserKabupatenKecamatan();
        } else {
            $kecamatans = $this->getUserProvinsiKecamatan();
        }

        return view('suara.edit', compact(['suara', 'pemilihan', 'kecamatans']));
    }

    public function update(Request $request, $id)
    {        
        $suara = SuaraPemilihan::find($id);

        $validator = Validator::make($request->all(), [
            'id_kecamatan' => 'required',
            'jumlah_kelurahan' => 'required',
            'jumlah_tps' => 'required',
            'jumlah_pemilih' => 'required',
            'jumlah_suara_tidak_sah' => 'required',
        ]);

        if ($request->id_kecamatan != $suara->id_kecamatan) {
            $suaraHere = SuaraPemilihan::where([
                'id_kecamatan' => $request->id_kecamatan,
                'id_pemilihan' => $suara->id_pemilihan,
            ])->first();

            if ($suaraHere) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('id_kecamatan', 'The Suara for this Kecamatan and Pemilihan already been taken.');
                });
            }

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $data = $request->only('id_kecamatan', 'jumlah_kelurahan', 'jumlah_tps', 'jumlah_pemilih', 'jumlah_suara_tidak_sah');
        $data['id_pemilihan'] = $suara->id_pemilihan;
        $data['jumlah_kelurahan'] = str_replace(".", "", $request->jumlah_kelurahan);
        $data['jumlah_tps'] = str_replace(".", "", $request->jumlah_tps);
        $data['jumlah_pemilih'] = str_replace(".", "", $request->jumlah_pemilih);
        $data['jumlah_suara_tidak_sah'] = str_replace(".", "", $request->jumlah_suara_tidak_sah);
        
        SuaraPemilihan::where('id', $id)->update($data);

        return redirect()->route('suara.index', $suara->id_pemilihan)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        $suaraPemilihan = SuaraPemilihan::find($id);

        try {
            SuaraPemilihan::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('suara.index', $suaraPemilihan->id_pemilihan)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
