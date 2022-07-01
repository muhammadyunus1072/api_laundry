<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OutletController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      $data['list'] = Outlet::all();

      return json_encode($data);
    }

    public function search(Request $request){
        $data['list'] = DB::table('outlets')
                            // ->where('nama', 'like','%'.$request->param.'%')
                            ->where('nama', 'like', '%'.$request->param.'%')
                            ->orwhere('alamat', 'like', '%'.$request->param.'%')
                            ->orwhere('tlp', 'like', '%'.$request->param.'%')
                            ->get();

        // $data['param'] = $request->param;
        return json_encode($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
        ]);

        if($validator->fails()){
            $data['validate'] = false;
            $data['error'] = $validator->errors();
        }else{
            $data['validate'] = true;
            $outlet = new Outlet();
    
            $outlet->nama = $request->nama;
            $outlet->alamat = $request->alamat;
            $outlet->tlp = $request->tlp;
    
            if($outlet->save()){
                $data['status'] = true;
                $data['list'] = Outlet::all();
            }else{
                $data['status'] = false;
            }
        }
        // $data['nama'] = $request->nama;
        // $data['alamat'] ="suh";
        // $data['tlp'] = $request->tlp;

        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $validator = Validator::make($request->all(),[
            'nama' => "required",
            "alamat" => "required",
            "tlp" => "required"
        ]);

        if($validator->fails()){
            $data['validate'] = false;
            $data['error'] = $validator->errors();
        }else{
            $data['validate'] = true;
            $outlet = Outlet::find($id);
    
            $outlet->nama = $request->nama;
            $outlet->alamat = $request->alamat;
            $outlet->tlp = $request->tlp;
    
            if($outlet->save()){
                $data['status'] = true;
                $data['list'] = Outlet::all();
            }else{
                $data['status'] = false;
            }
        }

        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $outlet = Outlet::find($id);

        if($outlet->delete()){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }

        return json_encode($data);
    }
}
