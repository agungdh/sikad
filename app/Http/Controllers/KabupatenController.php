<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Kabupaten;

use ADHhelper;

use DB;

class KabupatenController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:kabupaten');
    }

    public function index()
    {
        $kabupatens = Kabupaten::all();

        return view('kabupaten.index', compact(['kabupatens']));
    }

    public function create()
    {
        return view('kabupaten.create', compact([]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kabupaten' => 'required',
        ]);

        $data = $request->only('kabupaten');
        
        DB::table('kabupaten')->insert($data);

        return redirect()->route('kabupaten.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $kabupaten = Kabupaten::find($id);

        return view('kabupaten.edit', compact(['kabupaten']));
    }

    public function update(Request $request, $id)
    {        
        $request->validate([
            'kabupaten' => 'required',
        ]);

        $data = $request->only('kabupaten');
        
        Kabupaten::where('id', $id)->update($data);

        return redirect()->route('kabupaten.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        try {
            Kabupaten::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('kabupaten.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
