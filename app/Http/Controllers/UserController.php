<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Kabupaten;

use ADHhelper;

use Hash;
use DB;
use Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('Menu:user');
    }

    public function getAllKabupatens()
    {
        $kabupatens_raw = Kabupaten::all();
        $kabupatens = [];
        foreach ($kabupatens_raw as $item) {
            $kabupatens[$item->id] = "{$item->kabupaten}";
        }

        return $kabupatens;
    }

    public function index()
    {
        $users = User::with('kabupaten')->get();

        return view('user.index', compact(['users']));
    }

    public function create()
    {
        $kabupatens = $this->getAllKabupatens();

        return view('user.create', compact(['kabupatens']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'level' => 'required',
            'username' => 'required|unique:user,username',
            'password' => 'required|confirmed',
            'id_kabupaten' => 'required_if:level,opkab',
        ]);

        $data = $request->only('nama', 'level', 'username', 'id_kabupaten', 'password');
        $data['password'] = Hash::make($request->password);

        DB::table('user')->insert($data);

        return redirect()->route('user.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Tambah Data',
            'class' => 'success',
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $kabupatens = $this->getAllKabupatens();

        return view('user.edit', compact(['user', 'kabupatens']));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'nama' => 'required',
            'level' => 'required',
            'username' => [
                Rule::unique('user', 'username')->ignore($id),
            ],
            'password' => 'confirmed',
            'id_kabupaten' => 'required_if:level,opkab',
        ]);

        $data = $request->only('nama', 'level', 'username', 'id_kabupaten');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($data);

        return redirect()->route('user.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Data',
            'class' => 'success',
        ]);        
    }

    public function destroy($id)
    {
        try {
            User::where(['id' => $id])->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('alert', [
                'title' => 'ERROR !!!',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something Went Wrong !!!',
                'class' => 'error',
            ]);        
        }

        return redirect()->route('user.index')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Hapus Data',
            'class' => 'success',
        ]);        
    }
}
