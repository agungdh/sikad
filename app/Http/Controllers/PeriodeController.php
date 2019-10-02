<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Periode;

use ADHhelper;

use DB;

class PeriodeController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:periode');
    }

    public function index()
    {
        $periodes = Periode::all();

        return view('periode.index', compact(['periodes']));
    }

    public function create()
    {
        return view('periode.create', compact([]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required',
        ]);

        $data = $request->only('periode');
        
        DB::table('periode')->insert($data);

        return redirect()->route('periode.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $periode = Periode::find($id);

        return view('periode.edit', compact(['periode']));
    }

    public function update(Request $request, $id)
    {        
        $request->validate([
            'periode' => 'required',
        ]);

        $data = $request->only('periode');
        
        Periode::where('id', $id)->update($data);

        return redirect()->route('periode.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        try {
            Periode::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('periode.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
