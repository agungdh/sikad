<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ADHhelper;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Ruangan;

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

    public function getAutoCompleteData(Request $req)
    {
        switch ($req->tipe) {
            case 'ruangan':
            return $this->getRuangan($req->cari);
                break;            
            default:
                abort(404);
                break;
        }
    }

    private function getRuangan($cari)
    {
        return Jadwal::select('ruangan')
        ->distinct()
        ->where('ruangan', 'like', '%' . $cari . '%')
        ->limit(5)
        ->get();
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

        $datas = new Jadwal();
        $datas = $datas->join('dosen', 'jadwal.id_dosen', '=', 'dosen.id');
        $datas = $datas->join('matkul', 'jadwal.id_matkul', '=', 'matkul.id');
        $datas = $datas->select('jadwal.*', 'dosen.nama AS dosen', 'matkul.kode AS kodemk', 'matkul.matkul AS namamk');
        $datas = $datas->where('hari', 'like', '%' . $req->search['hari'] . '%');
        $datas = $datas->where('waktu', 'like', '%' . $req->search['waktu'] . '%');
        $datas = $datas->where('ruangan', 'like', '%' . $req->search['ruangan'] . '%');
        $datas = $datas->where('matkul.kode', 'like', '%' . $req->search['kodemk'] . '%');
        $datas = $datas->where('matkul.matkul', 'like', '%' . $req->search['namamk'] . '%');
        $datas = $datas->where('kelas', 'like', '%' . $req->search['kelas'] . '%');
        $datas = $datas->where('semester', 'like', '%' . $req->search['semester'] . '%');
        $datas = $datas->where('dosen.nama', 'like', '%' . $req->search['dosen'] . '%');
        $datas = $datas->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $datas = $datas->paginate($req->perPage);

        return response()->json($datas);
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

        $data = new Jadwal();
        $data->id_dosen = $request->id_dosen;
        $data->id_matkul = $request->id_matkul;
        $data->kelas = $request->kelas;
        $data->hari = $request->hari;
        $data->waktu = $request->waktu;
        $data->ruangan = $request->ruangan;
        $data->semester = $request->semester;
        $data->save();
    }

    public function show($id)
    {
        return Jadwal::with('matkul', 'dosen')->findOrFail($id);
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

        $data = Jadwal::findOrFail($id);
        $data->id_dosen = $request->id_dosen;
        $data->id_matkul = $request->id_matkul;
        $data->kelas = $request->kelas;
        $data->hari = $request->hari;
        $data->waktu = $request->waktu;
        $data->ruangan = $request->ruangan;
        $data->semester = $request->semester;
        $data->save();
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
    }
}
