<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\PaslonCapres;

use ADHhelper;

use DB;

class PaslonCapresController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:pasloncapres');
    }

    public function index()
    {
        $paslonCapresses = PaslonCapres::all();

        return view('pasloncapres.index', compact(['paslonCapresses']));
    }

    public function create()
    {
        return view('pasloncapres.create', compact([]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_urut' => 'required',
            'paslon_capres' => 'required',
            'foto' => 'image',
        ]);

        $data = $request->only('no_urut', 'paslon_capres');
        
        $id = DB::table('paslon_capres')->insertGetId($data);

        $foto = $request->file('foto');
        if ($foto) {            
            $foto->move(storage_path('app/public/files/foto'), $id);
        }

        return redirect()->route('pasloncapres.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $paslonCapres = PaslonCapres::find($id);

        return view('pasloncapres.edit', compact(['paslonCapres']));
    }

    public function update(Request $request, $id)
    {        
       $request->validate([
            'no_urut' => 'required',
            'paslon_capres' => 'required',
            'foto' => 'image',
        ]);

        $data = $request->only('no_urut', 'paslon_capres');
        
        PaslonCapres::where('id', $id)->update($data);

        $foto = $request->file('foto');
        if ($foto) {            
            $foto->move(storage_path('app/public/files/foto'), $id);
        }


        return redirect()->route('pasloncapres.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        try {
            if (file_exists(storage_path('app/public/files/foto/' . $id))) {
                unlink(storage_path('app/public/files/foto/' . $id));
            }
            PaslonCapres::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('pasloncapres.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
