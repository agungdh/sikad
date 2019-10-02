<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ADHhelper;

use App\Models\Test;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('Menu:test');
    }

    public function index()
    {
        return view('test.index');
    }

    public function getTableData(Request $req)
    {
        $columnModel[1] = "text1";
        $columnModel[2] = "text2";
        $columnModel[3] = "text3";

        $tests = new Test();
        $tests = $tests->where(function ($query) use ($req) {
            return $query->orWhere('text1', 'like', '%' . $req->search . '%')
                            ->orWhere('text2', 'like', '%' . $req->search . '%')
                            ->orWhere('text3', 'like', '%' . $req->search . '%');
        });
        $tests = $tests->orderBy($columnModel[$req->sorting['colNo']], $req->sorting['asc'] ? 'ASC' : 'DESC');
        $tests = $tests->paginate($req->perPage);

        return response()->json($tests);
    }


   public function store(Request $request)
    {
        $request->validate([
            'text1' => 'required',
            'text2' => 'required',
            'text3' => 'required',
        ]);

        $test = new Test();
        $test->text1 = $request->text1;
        $test->text2 = $request->text2;
        $test->text3 = $request->text3;
        $test->save();
    }

    public function show($id)
    {
        return Test::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text1' => 'required',
            'text2' => 'required',
            'text3' => 'required',
        ]);

        $test = Test::find($id);
        $test->text1 = $request->text1;
        $test->text2 = $request->text2;
        $test->text3 = $request->text3;
        $test->save();
    }

    public function destroy($id)
    {
        Test::find($id)->delete();
    }
}
