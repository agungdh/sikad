<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ADHhelper;

use App\Models\Dosen;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Dosen');
        $this->middleware('MustLoggedIn');
    }

    public function index()
    {
        return view('dosen.index');
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "nidn";
        $columnModel[2] = "nama";

        $dosens = new Dosen();
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

        $test = new Dosen();
        $test->nidn = $request->nidn;
        $test->nama = $request->nama;
        $test->save();
    }

    public function show($id)
    {
        return Dosen::findOrFail($id);
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

        $test = Dosen::findOrFail($id);
        $test->nidn = $request->nidn;
        $test->nama = $request->nama;
        $test->save();
    }

    public function delete($id)
    {
        Dosen::findOrFail($id)->delete();
    }
}
