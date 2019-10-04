<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ADHhelper;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\Matkul;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Jadwal Kuliah');
    }

    public function index()
    {
        return view('jadwal.index');
    }

    public function getDosen(Request $req)
    {
        return Dosen::where(function ($query) use ($req) {
            return $query->orWhere('nidn', 'like', '%' . $req->search . '%')
                            ->orWhere('nama', 'like', '%' . $req->search . '%');
        })->limit(10)
        ->get();
    }

    public function getMatkul(Request $req)
    {
        return Matkul::where(function ($query) use ($req) {
            return $query->orWhere('kode', 'like', '%' . $req->search . '%')
                            ->orWhere('matkul', 'like', '%' . $req->search . '%');
        })->limit(10)
        ->get();
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "hari";
        $columnModel[2] = "waktu";
        $columnModel[3] = "ruangan";
        $columnModel[4] = "kodemk";
        $columnModel[5] = "namamk";
        $columnModel[6] = "kelas";
        $columnModel[7] = "semester";
        $columnModel[8] = "dosen";

        $dosens = new Jadwal();
        $dosens = $dosens->join('dosen', 'jadwal.id_dosen', '=', 'dosen.id');
        $dosens = $dosens->join('matkul', 'jadwal.id_matkul', '=', 'matkul.id');
        $dosens = $dosens->select('jadwal.*', 'dosen.nama AS dosen', 'matkul.kode AS kodemk', 'matkul.matkul AS namamk');
        $dosens = $dosens->where('hari', 'like', '%' . $req->search['hari'] . '%');
        $dosens = $dosens->where('waktu', 'like', '%' . $req->search['waktu'] . '%');
        $dosens = $dosens->where('ruangan', 'like', '%' . $req->search['ruangan'] . '%');
        $dosens = $dosens->where('matkul.kode', 'like', '%' . $req->search['kodemk'] . '%');
        $dosens = $dosens->where('matkul.matkul', 'like', '%' . $req->search['namamk'] . '%');
        $dosens = $dosens->where('kelas', 'like', '%' . $req->search['kelas'] . '%');
        $dosens = $dosens->where('semester', 'like', '%' . $req->search['semester'] . '%');
        $dosens = $dosens->where('dosen.nama', 'like', '%' . $req->search['dosen'] . '%');
        $dosens = $dosens->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $dosens = $dosens->paginate($req->perPage);

        return response()->json($dosens);
    }


   public function store(Request $request)
    {
        $request->validate([
            'id_dosen' => 'required',
            'id_matkul' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
            'ruangan' => 'required',
            'semester' => 'required',
        ]);

        $test = new Jadwal();
        $test->id_dosen = $request->id_dosen;
        $test->id_matkul = $request->id_matkul;
        $test->kelas = $request->kelas;
        $test->hari = $request->hari;
        $test->waktu = $request->waktu;
        $test->ruangan = $request->ruangan;
        $test->semester = $request->semester;
        $test->save();
    }

    public function show($id)
    {
        return Jadwal::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_dosen' => 'required',
            'id_matkul' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'waktu' => 'required',
            'ruangan' => 'required',
            'semester' => 'required',
        ]);

        $test = Jadwal::findOrFail($id);
        $test->id_dosen = $request->id_dosen;
        $test->id_matkul = $request->id_matkul;
        $test->kelas = $request->kelas;
        $test->hari = $request->hari;
        $test->waktu = $request->waktu;
        $test->ruangan = $request->ruangan;
        $test->semester = $request->semester;
        $test->save();
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
    }
}
