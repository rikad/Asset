<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Asset;
use App\AssetDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;


class AssetsController extends \App\Http\Controllers\Controller
{


    private $validationRule = [
                'name' => 'required|unique:assets,name',
                'type' => 'required',
                'category' => 'required',
                'description' => 'required'
            ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));

            //yang di pinjam
            if ($request->input('mode') == 'pinjam') {
                $data = AssetDetail::select(DB::raw('@rownum  := @rownum  + 1 AS no'),'asset_details.*','users.name as peminjam','assets.name as name','assets.type');
                $data->join('assets','asset_details.asset_id','assets.id');
                $data->leftJoin('users','asset_details.user_id','users.id');
                $data->where('asset_details.user_id','<>',NULL);
                return Datatables::of($data)->make(true);
            }

            $rawSelect = '@rownum  := @rownum  + 1 AS no, SUM(IF(ISNULL(asset_details.room_id),1,0)) as available ,SUM(IF(asset_details.room_id,1,0)) as alocation,COUNT(assets.id) as jumlah';

            $data = Asset::select(DB::raw($rawSelect),'assets.*')
                    ->leftJoin('asset_details','asset_details.asset_id','assets.id')
                    ->groupBy('assets.id');

            return Datatables::of($data)->make(true);
        }

        return view('assets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assets.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        if (empty($data['asset_id'])) {
            $this->validate($request, $this->validationRule);
            $db = Asset::create($data);
        } else {
            $db = Asset::find($data['asset_id']);
        }

        $assetDetail = $data['detailBarang'];


        for ($i=0; $i < count($assetDetail); $i++) {

            $condition = $assetDetail[$i][6] == 'Rusak Ringan' ? 1 : 0;  // 0 baik , 1 RR, 2 RB
            $condition = $assetDetail[$i][6] == 'Rusak Berat' ? 2 : 0;

            AssetDetail::create(['asset_id'=>$db->id,'serial'=>$assetDetail[$i][0],'no_po'=>$assetDetail[$i][1],'no_bst'=>$assetDetail[$i][2],'sourcefund'=>$assetDetail[$i][3],'price'=>$assetDetail[$i][4],'year'=>$assetDetail[$i][5],'condition'=>$condition]);
        }


        //response section
        if ($request->ajax()) {
            return 'Berhasil Di Simpan';
        }

        Session::flash("status", [
            "level"=>"success",
            "message"=>"Berhasil Di Simpan"
        ]);

        return redirect()->route('assets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {

        $data = Asset::find($id);
        $detail = AssetDetail::select('asset_details.*',DB::raw('IF(asset_details.condition=0 ,"Baik",IF(asset_details.condition=1,"Rusak Ringan","Rusak Berat")) AS conditionText'), 'rooms.name as roomName')
            ->leftJoin('rooms','rooms.id','asset_details.room_id')
            ->where('asset_id',$id)->get();
        $output = ['data'=>$data,'detail'=>$detail];


        //response section
        if (Auth::check() && Auth::user()->can('read-assets')) {

            if ($request->ajax()) {
                return $output;
            }

            return view('assets.show',$output);

        } else {
            return view('assets.showPublic',$output);
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
        $data = Asset::find($id);

        return view('assets.edit')->with(compact('data'));
    }


    public function downloadDoc()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $user_id = Auth::id();
            
        if(assetDetail::where('user_id',$user_id)->first()) {
            Session::flash("status", [
                "level"=>"warning",
                "message"=>"Anda Belum Mengembalikan Assets, Kembalikan Assets untuk mendownload Form Bebas Pinjam"
            ]);
            return redirect()->route('users.showPublic',$user_id);
        }


        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'doc' . DIRECTORY_SEPARATOR . 'Bebas Pinjam Wis April 2018.docx';

        return response()->download($destinationPath);
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
        $this->validationRule['name'] = $this->validationRule['name'].','.$id; //exception unique rule for name
        $this->validationRule['image'] = 'image|max:2048'; //image validation

        $this->validate($request, $this->validationRule);

        $data = $request->all();

        $db = Asset::find($id);
        $db->update($data);

        if ($request->hasFile('image')) {
            //ambbil file upload
            $uploaded_cover = $request->file('image');

            //ambil extension
            $extension = $uploaded_cover->getClientOriginalExtension();

            //buat file random dan extension
            $filename= md5(time()) . '.' . $extension;

            //menyimpan
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assets';
            $uploaded_cover->move($destinationPath, $filename);

            //isi field cover di book
            $db->image = $filename;
            $db->save();

            //delete old image
            Storage::delete($destinationPath.DIRECTORY_SEPARATOR.$db->image);
        }

        Session::flash("status", [
            "level"=>"success",
            "message"=>"Berhasil Di Simpan"
        ]);

        return redirect()->route('assets.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $db = Asset::find($id);

        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assets';
        Storage::delete($destinationPath.DIRECTORY_SEPARATOR.$db->image);

        $db->delete();


        Session::flash("status", [
            "level"=>"danger",
            "message"=>"Berhasil Di Hapus"
        ]);

        return 'ok';
    }

}
