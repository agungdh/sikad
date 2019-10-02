<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\CalonDPD;
use App\Models\Partai;

use ADHhelper;

use DB;

class CalonDPDController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:calondpd');
    }

    public function index()
    {
        $calonDPDs = CalonDPD::with('partai')->get();

        return view('calondpd.index', compact(['calonDPDs']));
    }

    public function getAllPartais()
    {
        $partais_raw = Partai::all();
        $partais = [];
        foreach ($partais_raw as $item) {
            $partais[$item->id] = "{$item->partai}";
        }

        return $partais;
    }

    public function create()
    {
        $partais = $this->getAllPartais();

        return view('calondpd.create', compact(['partais']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $data = $request->only('nama', 'id_partai');
        
        DB::table('calon_dpd')->insert($data);

        return redirect()->route('calondpd.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $calonDPD = CalonDPD::find($id);
        $partais = $this->getAllPartais();

        return view('calondpd.edit', compact(['calonDPD', 'partais']));
    }

    public function update(Request $request, $id)
    {        
        $request->validate([
            'nama' => 'required',
        ]);

        $data = $request->only('nama', 'id_partai');
        
        CalonDPD::where('id', $id)->update($data);

        return redirect()->route('calondpd.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {     
        try {
            CalonDPD::where(['id' => $id])->delete();   
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('calondpd.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
