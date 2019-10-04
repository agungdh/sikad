<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ADHhelper;

use App\Models\Matkul;

class MatkulController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Mata Kuliah');
    }

    public function index()
    {
        return view('matkul.index');
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "kode";
        $columnModel[2] = "matkul";

        $matkuls = new Matkul();
        $matkuls = $matkuls->where('kode', 'like', '%' . $req->search['kode'] . '%');
        $matkuls = $matkuls->where('matkul', 'like', '%' . $req->search['matkul'] . '%');
        $matkuls = $matkuls->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $matkuls = $matkuls->paginate($req->perPage);

        return response()->json($matkuls);
    }


   public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:matkul,kode',
            'matkul' => 'required',
        ]);

        $test = new Matkul();
        $test->kode = $request->kode;
        $test->matkul = $request->matkul;
        $test->save();
    }

    public function show($id)
    {
        return Matkul::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => [
                'required',
                Rule::unique('matkul')->ignore($id),
            ],
            'matkul' => 'required',
        ]);

        $test = Matkul::find($id);
        $test->kode = $request->kode;
        $test->matkul = $request->matkul;
        $test->save();
    }

    public function delete($id)
    {
        Matkul::find($id)->delete();
    }
}