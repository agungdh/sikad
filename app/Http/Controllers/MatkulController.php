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

        $datas = new Matkul();
        $datas = $datas->where('kode', 'like', '%' . $req->search['kode'] . '%');
        $datas = $datas->where('matkul', 'like', '%' . $req->search['matkul'] . '%');
        $datas = $datas->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $datas = $datas->paginate($req->perPage);

        return response()->json($datas);
    }


   public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:matkul,kode',
            'matkul' => 'required',
        ]);

        $data = new Matkul();
        $data->kode = $request->kode;
        $data->matkul = $request->matkul;
        $data->save();
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

        $data = Matkul::findOrFail($id);
        $data->kode = $request->kode;
        $data->matkul = $request->matkul;
        $data->save();
    }

    public function destroy($id)
    {
        Matkul::findOrFail($id)->delete();
    }
}
