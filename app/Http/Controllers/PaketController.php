<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class PaketController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //
        $data['outlet'] = Outlet::all();
        $data['paket'] = Paket::all();
        // $data['jenis'] = Jenis::all();

        return json_encode($data);
    }

    public function search(Request $request){
        $data['paket'] = DB::table('pakets')
                            ->where('jenis', 'like', '%'.$request->param.'%')
                            ->orwhere('nama_paket', 'like', '%'.$request->param.'%')
                            ->orwhere('harga', 'like', '%'.$request->param.'%')
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
        $validator = Validator::make($request->all(),[
            "jenis" => "required",
            "nama_paket" => "required",
            "harga" => "required",
        ]);

        if($validator->fails()){
            $data['validate'] = false;
            $data['error'] = $validator->errors();
        }else {
            $data['validate'] = true;
            $paket = new Paket();
    
            $paket->jenis = $request->jenis;
            $paket->nama_paket = $request->nama_paket;
            $paket->harga = $request->harga;

            if($paket->save()){
                $data['status'] = true;
                $data['paket'] = Paket::all();
            }else{
                $data['status'] = false;
            }
        }

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
            "jenis" => "required",
            "nama_paket" => "required",
            "harga" => "required | numeric",
        ]);

        if($validator->fails()){
            $data['validate'] = false;
            $data['error'] = $validator->errors();
        }else {
            $data['validate'] = true;
            $paket = Paket::find($id);
    
            $paket->jenis = $request->jenis;
            $paket->nama_paket = $request->nama_paket;
            $paket->harga = $request->harga;

            if($paket->save()){
                $data['status'] = true;
                $data['paket'] = Paket::all();
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
        $paket = Paket::find($id);

        if($paket->delete()){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }

        return json_encode($data);
    }
}
