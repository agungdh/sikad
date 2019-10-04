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
        $columnModel[1] = "nidn";
        $columnModel[2] = "nama";

        $dosens = new Matkul();
        $dosens = $dosens->where('nidn', 'like', '%' . $req->search['nidn'] . '%');
        $dosens = $dosens->where('nama', 'like', '%' . $req->search['nama'] . '%');
        $dosens = $dosens->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $dosens = $dosens->paginate($req->perPage);

        return response()->json($dosens);
    }


   public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|unique:dosen,nidn',
            'nama' => 'required',
        ]);

        $test = new Matkul();
        $test->nidn = $request->nidn;
        $test->nama = $request->nama;
        $test->save();
    }

    public function show($id)
    {
        return Matkul::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nidn' => [
                'required',
                Rule::unique('dosen')->ignore($id),
            ],
            'nama' => 'required',
        ]);

        $test = Matkul::find($id);
        $test->nidn = $request->nidn;
        $test->nama = $request->nama;
        $test->save();
    }

    public function delete($id)
    {
        Matkul::find($id)->delete();
    }
}
