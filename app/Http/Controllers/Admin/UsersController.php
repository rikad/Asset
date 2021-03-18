<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\AssetDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;


class UsersController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            DB::statement(DB::raw('set @rownum=0'));
            $data = User::select(DB::raw('@rownum  := @rownum  + 1 AS no'),'users.*');

            if ($request->input('type')) {
                $data->join('role_user','role_user.user_id','users.id');
                $data->join('roles','role_user.role_id','roles.id');
                $data->where('roles.name',$request->input('type'));

                if ($request->input('angkatan')) {
                    $data->where(DB::raw('MID(users.noid,4,2)'),substr($request->input('angkatan'), 2));
                }
            }

            return Datatables::of($data)->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.form');
    }


    public function setFBP(Request $request)
    {
        $fileenv = DotenvEditor::load();
        $fileenv->setKey('APP_SASPRA',$request->input('saspra'));
        $fileenv->setKey('APP_PERPUS',$request->input('perpus'));
        $fileenv->setKey('APP_PRODI',$request->input('prodi'));
        $fileenv->save();

        return 'ok';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('import')) {
            $import = json_decode($request->input('import'));


            foreach ($import as $key => $value) {
                $tmp = (array) $value;
                $tmp['password'] = bcrypt($tmp['password']);
                $tmp['desc'] = json_encode($tmp['desc']);
                $db = User::create($tmp);
                $db->attachRole($request->input('role'));
            }

            return 'ok';
        }

        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email',
            'is_active' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $db = User::create($data);

        $db->attachRole($request->input('role'));

        Session::flash("status", [
            "level"=>"success",
            "message"=>"Berhasil Di Simpan"
        ]);

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

        $data = User::find($id);
        $detail = AssetDetail::select('asset_details.*',DB::raw('IF(asset_details.condition=0 ,"Baik",IF(asset_details.condition=1,"Rusak Ringan","Rusak Berat")) AS conditionText'), 'rooms.name as roomName', 'assets.name')
            ->join('assets','assets.id','asset_details.asset_id')
            ->join('users','users.id','asset_details.user_id')
            ->leftJoin('rooms','rooms.id','asset_details.room_id')
            ->where('asset_details.user_id',$id)->get();

        $fileenv = DotenvEditor::load();
        $saspra = $fileenv->getValue('APP_SASPRA');
        $perpus = $fileenv->getValue('APP_PERPUS');
        $prodi = $fileenv->getValue('APP_PRODI');

        $output = [
            'data'=>$data,
            'detail'=>$detail,
            'saspra'=>$saspra,
            'perpus'=>$perpus,
            'prodi'=>$prodi,
        ];


        //response section
        if (Auth::check()) {
            if (Auth::user()->can('read-users') || Auth::user()->can('read-mahasiswa')) {

                if ($request->ajax()) {
                    //form bebas pinjam check
                    $cek = assetDetail::where('user_id',$id)->get();

                    if (count($cek) > 0) {
                        return 'not-ok';
                    }

                    return $output;
                }

                return view('users.show',$output);
            } else {
                return view('users.showPublic',$output);
                
            }
        }
        else {
            return view('users.showPublic',$output);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::select('users.*','roles.id as role')
                ->join('role_user','role_user.user_id','users.id')
                ->join('roles','role_user.role_id','roles.id')
                ->find($id);

        $data->password = '';

        return view('users.form')->with(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username,'.$id,
            'name' => 'required',
            'password' => 'nullable',
            'email' => 'required|email|unique:users,email,'.$id,
            'is_active' => 'required|numeric',
        ]);

        if ($request->input('password') == null) {
            $data = $request->except('password');
        } else {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
        }

        if ($request->input('role') == 4) { //for mahasiswa

            $desc = [
                'wali' => $data['wali'],
                'pembimbing1' => $data['pembimbing1'],
                'pembimbing2' => $data['pembimbing2'],
                'plab' => $data['plab'],
                'lab' => $data['lab'],
                'wisuda' => $data['wisuda'],
            ];

            $data['desc'] = json_encode($desc);
        }

        $db = User::select('users.*','roles.id as role')
                ->join('role_user','role_user.user_id','users.id')
                ->join('roles','role_user.role_id','roles.id')
                ->find($id);

        $db->detachRole($db->role);

        $db->update($data);
        $db->attachRole($request->input('role'));

        Session::flash("status", [
            "level"=>"success",
            "message"=>"Berhasil Di Simpan"
        ]);

        if ($request->input('role') == 4) { //for mahasiswa

            return redirect()->route('mahasiswa');

        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $db = User::find($id);
        $db->delete();

        Session::flash("status", [
            "level"=>"danger",
            "message"=>"Berhasil Di Hapus"
        ]);

        return 'ok';
    }
}
