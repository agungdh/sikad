<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\User;
use App\Models\Pemilihan;
use App\Models\Kabupaten;

use DB;
use Hash;
use ADHhelper;

use Dompdf\Dompdf;
use Dompdf\Options;

class MainController extends Controller
{

	public function pdfsuarapartai($id_pemilihan)
	{
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$partais = DB::select('SELECT *
			FROM partai
			WHERE id IN (
			SELECT DISTINCT(pt.id) id_partai
			FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, partai pt
			WHERE ds.id_suara_pemilihan = sp.id
			AND sp.id_pemilihan = pl.id
			AND ds.id_partai = pt.id
			AND pl.id = ?
		)', [$pemilihan->id]);

    	$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);
		$contxt = stream_context_create([ 
		    'ssl' => [ 
		        'verify_peer' => FALSE, 
		        'verify_peer_name' => FALSE,
		        'allow_self_signed'=> TRUE
		    ] 
		]);
		$dompdf->setHttpContext($contxt);
		$dompdf->loadHtml(view('dashboard.pdfsuarapartai', compact(['pemilihan', 'kabupatens', 'partais'])));
		$dompdf->setPaper('A1', 'landscape');
		$dompdf->render();
		$dompdf->stream(date('Ymdhis'), array("Attachment" => false));
	}

	public function pdfsuaradpd($id_pemilihan)
	{
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$dpds = DB::select('SELECT *
			FROM calon_dpd
			WHERE id IN (
			SELECT DISTINCT(cd.id) id_calon_dpd
			FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, calon_dpd cd
			WHERE ds.id_suara_pemilihan = sp.id
			AND sp.id_pemilihan = pl.id
			AND ds.id_calon_dpd = cd.id
			AND pl.id = ?
		)', [$pemilihan->id]);

		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);
		$contxt = stream_context_create([ 
		    'ssl' => [ 
		        'verify_peer' => FALSE, 
		        'verify_peer_name' => FALSE,
		        'allow_self_signed'=> TRUE
		    ] 
		]);
		$dompdf->setHttpContext($contxt);
		$dompdf->loadHtml(view('dashboard.pdfsuaradpd', compact(['pemilihan', 'kabupatens', 'dpds']))->render());
		$dompdf->setPaper('A1', 'landscape');
		$dompdf->render();
		$dompdf->stream(date('Ymdhis'), array("Attachment" => false));
	}

	public function pdfsuaracapres($id_pemilihan)
	{
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$capress = DB::select('SELECT *
			FROM paslon_capres
			WHERE id IN (
			    SELECT DISTINCT(pc.id) id_paslon_capres
			    FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, paslon_capres pc
			    WHERE ds.id_suara_pemilihan = sp.id
			    AND sp.id_pemilihan = pl.id
			    AND ds.id_paslon_capres = pc.id
				AND pl.id = ?
			)', [$pemilihan->id]);

        $options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$dompdf = new Dompdf($options);
		$contxt = stream_context_create([ 
		    'ssl' => [ 
		        'verify_peer' => FALSE, 
		        'verify_peer_name' => FALSE,
		        'allow_self_signed'=> TRUE
		    ] 
		]);
		$dompdf->setHttpContext($contxt);
		$dompdf->loadHtml(view('dashboard.pdfsuaracapres', compact(['pemilihan', 'kabupatens', 'capress'])));
		$dompdf->setPaper('A1', 'landscape');
		$dompdf->render();
		$dompdf->stream(date('Ymdhis'), array("Attachment" => false));
	}

	public function dashboardsuarapartai($id_pemilihan)
    {
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$partais = DB::select('SELECT *
			FROM partai
			WHERE id IN (
			SELECT DISTINCT(pt.id) id_partai
			FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, partai pt
			WHERE ds.id_suara_pemilihan = sp.id
			AND sp.id_pemilihan = pl.id
			AND ds.id_partai = pt.id
			AND pl.id = ?
		)', [$pemilihan->id]);

        return view('dashboard.suarapartai', compact(['pemilihan', 'kabupatens', 'partais']));
    }

	public function dashboardsuaradpd($id_pemilihan)
    {
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$dpds = DB::select('SELECT *
			FROM calon_dpd
			WHERE id IN (
			SELECT DISTINCT(cd.id) id_calon_dpd
			FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, calon_dpd cd
			WHERE ds.id_suara_pemilihan = sp.id
			AND sp.id_pemilihan = pl.id
			AND ds.id_calon_dpd = cd.id
			AND pl.id = ?
		)', [$pemilihan->id]);
    	
        return view('dashboard.suaradpd', compact(['pemilihan', 'kabupatens', 'dpds']));
    }

	public function dashboardsuaracapres($id_pemilihan)
    {
    	$kabupatens = Kabupaten::all();
        $pemilihan = Pemilihan::find($id_pemilihan);
    	$capress = DB::select('SELECT *
			FROM paslon_capres
			WHERE id IN (
			    SELECT DISTINCT(pc.id) id_paslon_capres
			    FROM pemilihan pl, suara_pemilihan sp, detil_suara_pemilihan ds, paslon_capres pc
			    WHERE ds.id_suara_pemilihan = sp.id
			    AND sp.id_pemilihan = pl.id
			    AND ds.id_paslon_capres = pc.id
				AND pl.id = ?
			)', [$pemilihan->id]);

        return view('dashboard.suaracapres', compact(['pemilihan', 'kabupatens', 'capress']));
    }

    function profil() {
    	$profil = ADHhelper::getUserData();

		return view('template.profil', compact(['profil']));
	}

    function saveProfil(Request $request) {
    	$request->validate([
    		'password' => 'required|confirmed',
    	]);
    	
    	$datas = [];
		$datas['password'] = Hash::make($request->password);


		User::where(['id' => session('userID')])->update($datas);

		return redirect()->route('main.profil')->with('alert', [
            'title' => 'BERHASIL !!!',
            'message' => 'Berhasil Ubah Profil',
            'class' => 'success',
        ]);
	}

    function index() {
		if (session('login') == true) {
	        $pemilihans = Pemilihan::all();
			return view('dashboard.index', compact(['pemilihans']));
		} else {
			return view('template.login');
		}
	}

	function login(Request $request) {
		$user = User::where(['username' => $request->username])->first();
		if ($user != null && Hash::check($request->password, $user->password)) {
			$userData = [];
			$userData['userID'] = $user->id;
			$userData['login'] = true;

			session($userData);

			return redirect()->route('main.index');
		} else {
			return redirect()->route('main.index')->with('alert', [
                'title' => 'GAGAL !!!',
                'message' => 'Username atau Password Salah !!!',
                'class' => 'error',
            ]);
		}
	}

	function logout() {
		session()->flush();

		return redirect()->route('main.index');
	}
}
