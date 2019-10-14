<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ADHhelper;

use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Mahasiswa');
    }

    public function index()
    {
        return view('mahasiswa.index');
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "npm";
        $columnModel[2] = "nama";

        $datas = new Mahasiswa();
        $datas = $datas->where('npm', 'like', '%' . $req->search['npm'] . '%');
        $datas = $datas->where('nama', 'like', '%' . $req->search['nama'] . '%');
        $datas = $datas->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $datas = $datas->paginate($req->perPage);

        return response()->json($datas);
    }


   public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required|unique:mahasiswa,npm',
            'nama' => 'required',
        ]);

        $data = new Mahasiswa();
        $data->npm = $request->npm;
        $data->nama = $request->nama;
        $data->save();
    }

    public function show($id)
    {
        return Mahasiswa::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'npm' => [
                'required',
                Rule::unique('mahasiswa')->ignore($id),
            ],
            'nama' => 'required',
        ]);

        $data = Mahasiswa::findOrFail($id);
        $data->npm = $request->npm;
        $data->nama = $request->nama;
        $data->save();
    }

    public function destroy($id)
    {
        Mahasiswa::findOrFail($id)->delete();
    }
}
