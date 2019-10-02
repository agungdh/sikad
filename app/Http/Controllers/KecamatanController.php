<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Kabupaten;
use App\Models\Kecamatan;

use ADHhelper;

use DB;
use Validator;

class KecamatanController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:kabupaten');
    }

    public function index($id_kabupaten)
    {
        $kabupaten = Kabupaten::with('kecamatans')->find($id_kabupaten);
        $kecamatans = $kabupaten->kecamatans;

        return view('kecamatan.index', compact(['kabupaten', 'kecamatans']));
    }

    public function create($id_kabupaten)
    {
        $kabupaten = Kabupaten::find($id_kabupaten);

        return view('kecamatan.create', compact(['kabupaten']));
    }

    public function store(Request $request, $id_kabupaten)
    {
        $request->validate([
            'kecamatan' => 'required',
        ]);

        $data = $request->only('kecamatan');
        $data['id_kabupaten'] = $id_kabupaten;
        
        DB::table('kecamatan')->insert($data);

        return redirect()->route('kecamatan.index', $id_kabupaten)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::with('kabupaten')->find($id);
        $kabupaten = $kecamatan->kabupaten;

        return view('kecamatan.edit', compact(['kecamatan', 'kabupaten']));
    }

    public function update(Request $request, $id)
    {        
        $kecamatan = Kecamatan::find($id);

        $request->validate([
            'kecamatan' => 'required',
        ]);

        $data = $request->only('kecamatan');

        Kecamatan::where(['id' => $id])->update($data);

        return redirect()->route('kecamatan.index', $kecamatan->id_kabupaten)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        $kecamatan = Kecamatan::find($id);

        try {
            Kecamatan::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('kecamatan.index', $kecamatan->id_kabupaten)->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
