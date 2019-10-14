<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Validator;
use ADHhelper;

use App\Models\JadwalAktif;
use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Mahasiswa;

class JadwalAktifController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:Jadwal Aktif');
    }

    public function index()
    {
        return view('jadwalaktif.index');
    }

    public function getJadwal(Request $req)
    {
        $datas = new Jadwal();
        $datas = $datas->join('dosen', 'jadwal.id_dosen', '=', 'dosen.id');
        $datas = $datas->join('matkul', 'jadwal.id_matkul', '=', 'matkul.id');
        $datas = $datas->select('jadwal.*', 'dosen.nidn AS nidn', 'dosen.nama AS nama', 'matkul.kode AS kodemk', 'matkul.matkul AS namamk');
        $datas = $datas->where(function ($query) use ($req) {
            return $query->orWhere('dosen.nidn', 'like', '%' . $req->search . '%')
                            ->orWhere('dosen.nama', 'like', '%' . $req->search . '%')
                            ->orWhere('matkul.kode', 'like', '%' . $req->search . '%')
                            ->orWhere('matkul.matkul', 'like', '%' . $req->search . '%')
                            ->orWhere('jadwal.kelas', 'like', '%' . $req->search . '%')
                            ->orWhere('jadwal.hari', 'like', '%' . $req->search . '%')
                            ->orWhere('jadwal.waktu', 'like', '%' . $req->search . '%')
                            ->orWhere('jadwal.ruangan', 'like', '%' . $req->search . '%')
                            ->orWhere('jadwal.semester', 'like', '%' . $req->search . '%');
        });
        return $datas->limit(10)->get();
    }

    public function getMahasiswa(Request $req)
    {
        return Mahasiswa::where(function ($query) use ($req) {
            return $query->orWhere('npm', 'like', '%' . $req->search . '%')
                            ->orWhere('nama', 'like', '%' . $req->search . '%');
        })->limit(10)
        ->get();
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "nidn";
        $columnModel[2] = "nama";
        $columnModel[3] = "kodemk";
        $columnModel[4] = "namamk";
        $columnModel[5] = "npm";
        $columnModel[6] = "namamhs";
        $columnModel[7] = "hari";
        $columnModel[8] = "waktu";
        $columnModel[9] = "ruangan";
        $columnModel[10] = "semester";
        $columnModel[11] = "kelas";

        $datas = new JadwalAktif();
        $datas = $datas->with('jadwal');
        $datas = $datas->join('jadwal', 'jadwal_aktif.id_jadwal', '=', 'jadwal.id');
        $datas = $datas->join('mahasiswa', 'jadwal_aktif.id_mahasiswa', '=', 'mahasiswa.id');
        $datas = $datas->join('dosen', 'jadwal.id_dosen', '=', 'dosen.id');
        $datas = $datas->join('matkul', 'jadwal.id_matkul', '=', 'matkul.id');
        $datas = $datas->select('jadwal_aktif.*', 'dosen.nidn AS nidn', 'dosen.nama AS nama', 'matkul.kode AS kodemk', 'matkul.matkul AS namamk', 'mahasiswa.npm AS npm', 'mahasiswa.nama AS namamhs');
        $datas = $datas->where('dosen.nidn', 'like', '%' . $req->search['nidn'] . '%');
        $datas = $datas->where('dosen.nama', 'like', '%' . $req->search['nama'] . '%');
        $datas = $datas->where('matkul.kode', 'like', '%' . $req->search['kodemk'] . '%');
        $datas = $datas->where('matkul.matkul', 'like', '%' . $req->search['namamk'] . '%');
        $datas = $datas->where('mahasiswa.npm', 'like', '%' . $req->search['npm'] . '%');
        $datas = $datas->where('mahasiswa.nama', 'like', '%' . $req->search['namamhs'] . '%');
        $datas = $datas->where('jadwal.hari', 'like', '%' . $req->search['hari'] . '%');
        $datas = $datas->where('jadwal.waktu', 'like', '%' . $req->search['waktu'] . '%');
        $datas = $datas->where('jadwal.ruangan', 'like', '%' . $req->search['ruangan'] . '%');
        $datas = $datas->where('jadwal.semester', 'like', '%' . $req->search['semester'] . '%');
        $datas = $datas->where('jadwal.kelas', 'like', '%' . $req->search['kelas'] . '%');
        $datas = $datas->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $datas = $datas->paginate($req->perPage);

        return response()->json($datas);
    }


   public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jadwal' => 'required',
            'id_mahasiswa' => 'required', 
        ]);

        if (JadwalAktif::where(['id_jadwal' => $request->id_jadwal, 'id_mahasiswa' => $request->id_mahasiswa])->first()) {
            $validator->after(function ($validator) {
                $validator->errors()->add('id_jadwal', 'The id_jadwal already been taken.');
                $validator->errors()->add('id_mahasiswa', 'The id_mahasiswa already been taken.');
            });
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'The given data was invalid.'], 422);
        }

        $data = new JadwalAktif();
        $data->id_jadwal = $request->id_jadwal;
        $data->id_mahasiswa = $request->id_mahasiswa;
        $data->save();
    }

    public function destroy($id)
    {
        JadwalAktif::findOrFail($id)->delete();
    }
}
