<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ADHhelper;

use App\Models\Dosen;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Dosen');
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
        $dosens = $dosens->where(function ($query) use ($req) {
            return $query->orWhere('nidn', 'like', '%' . $req->search . '%')
                            ->orWhere('nama', 'like', '%' . $req->search . '%');
        });
        $dosens = $dosens->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $dosens = $dosens->paginate($req->perPage);

        return response()->json($dosens);
    }


   public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required',
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
            'nidn' => 'required',
            'nama' => 'required',
            'text3' => 'required',
        ]);

        $test = Dosen::find($id);
        $test->nidn = $request->nidn;
        $test->nama = $request->nama;
        $test->text3 = $request->text3;
        $test->save();
    }

    public function delete($id)
    {
        Dosen::find($id)->delete();
    }
}
