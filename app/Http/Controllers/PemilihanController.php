<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Pemilihan;
use App\Models\Periode;

use ADHhelper;

use DB;
use Validator;
use Session;

class PemilihanController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:pemilihan');
    }

    public function getAllTipes()
    {
        return [
            'presiden' => 'Presiden',
            'dpr' => 'DPR',
            'dpd' => 'DPD',
            'dprdp' => 'DPRD Provinsi',
            'dprdk' => 'DPRD Kabupaten / Kota',
        ];
    }

    public function getAllPeriodes()
    {
        $periodes_raw = Periode::all();
        $periodes = [];
        foreach ($periodes_raw as $item) {
            $periodes[$item->id] = "{$item->periode}";
        }

        return $periodes;
    }

    public function index()
    {
        $pemilihans = Pemilihan::all();

        return view('pemilihan.index', compact(['pemilihans']));
    }

    public function create()
    {
        $periodes = $this->getAllPeriodes();
        $tipes = $this->getAllTipes();

        return view('pemilihan.create', compact(['periodes', 'tipes']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_periode' => 'required',
            'tipe' => 'required',
        ]);

        $pemilihan = Pemilihan::where([
            'id_periode' => $request->id_periode,
            'tipe' => $request->tipe,
        ])->first();

        if ($pemilihan) {
            $validator->after(function ($validator) {
                $validator->errors()->add('id_periode', 'The Periode and Tipe has already been taken.');
                $validator->errors()->add('tipe', 'The Periode and Tipe has already been taken.');
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = $request->only('id_periode', 'tipe');
        
        DB::table('pemilihan')->insert($data);

        return redirect()->route('pemilihan.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $pemilihan = Pemilihan::find($id);
        $periodes = $this->getAllPeriodes();
        $tipes = $this->getAllTipes();

        return view('pemilihan.edit', compact(['pemilihan', 'periodes', 'tipes']));
    }

    public function update(Request $request, $id)
    {        
        $pemilihan = Pemilihan::find($id);

        $validator = Validator::make($request->all(), [
            'id_periode' => 'required',
            'tipe' => 'required',
        ]);

        if ($request->id_periode != $pemilihan->id_periode || $request->tipe != $pemilihan->tipe) {
            $pemilihanHere = Pemilihan::where([
                'id_periode' => $request->id_periode,
                'tipe' => $request->tipe,
            ])->first();

            if ($pemilihanHere) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('id_periode', 'The Periode and Tipe has already been taken.');
                    $validator->errors()->add('tipe', 'The Periode and Tipe has already been taken.');
                });
            }

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $data = $request->only('id_periode', 'tipe');
        
        Pemilihan::where('id', $id)->update($data);

        return redirect()->route('pemilihan.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        try {
            Pemilihan::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('pemilihan.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
