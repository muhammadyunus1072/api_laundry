<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Paket;
use App\Models\Outlet;
use App\Models\Transaksi;
use App\Models\StatusOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class TransaksiController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
        $data['pelanggan'] = User::with('role')->where('role_id', '=', '3')->get();
        // $data['outlet'] = Outlet::all();
        $data['paket'] = Paket::all();
        // $data = Transaksi::with('outlet')->get();
        $data['outlet'] = Outlet::all();
        // $data['user'] = Transaksi::find(1)->user;
        $data['list'] = Transaksi::with('detail_transaksi', 'outlet', 'user', 'statusOrder')->orderBy('statusOrder_id')->get();
        // $data['petugas'] = View_user::where("id_role","=","1")->orwhere("id_role","=","2")->get();

        // $data['list'] = View_transaksi::groupBy('id')->orderBy('status','asc')->orderBy('batas_waktu','asc')->orderBy('dibayar','asc')->orderBy('tgl','asc')->orderBy('nama','asc')->get();

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
        // return json_encode(Transaksi::with('outlet')->get());
        $validate = Validator::make($request->all(),[
            'kode_invoice' => 'required',
            'user_id' => 'required',
            'outlet_id' => 'required',
            'total' => 'required',
            'statusOrder' => 'required',
            'statusBayar' => 'required',
            'detail' => 'required',
        ]);
        if($validate->fails()){
            $data['status'] = 'failed';
            $data['error'] = $validate->errors();
            return json_encode($data);
        }
        // $data['list'] = $request->all();
        $tran = new Transaksi();

        $tran->kode_invoice = $request->kode_invoice;
        $tran->tgl = date('Y-m-d');
        $tran->total = $request->total;
        $tran->statusOrder_id = $request->statusOrder;
        $tran->statusBayar = $request->statusBayar;
        $tran->user_id = $request->user_id;
        $tran->outlet_id = $request->outlet_id;

        if($tran->save()){
            $data['status'] = true;
            
            $le = count($request->detail);
            $id = $tran->id;
            for($a = 0; $a < $le ; $a++){
                // return json_encode($request->detail[$a]['id_paket']);
                
                $kodeP = $request->detail[$a]['id_paket'];
                $harga = $request->detail[$a]['harga'];
                $subtotal = $request->detail[$a]['total'];
                $qty = $request->detail[$a]['qty'];
                $ket = $request->detail[$a]['keterangan'];
                DB::table('detail_transaksis')->insert(
                    ['transaksi_id' => $id, 'paket_id' => $kodeP, 'qty' => $qty, 'keterangan' => $ket, 'harga' => $harga, 'subtotal' => $subtotal]
                );
            
                $data['print'] = Transaksi::with('outlet', 'user')->where('id','=',$id)->get();
                $data['petugas'] = auth()->user()->name;
            }
            
            // $data['list'] = View_transaksi::groupBy('id')->orderBy('status','asc')->orderBy('batas_waktu','asc')->orderBy('dibayar','asc')->orderBy('tgl','asc')->orderBy('nama','asc')->get();
            
        }else{
            $data['status'] = false;
        }

        return json_encode($data);
    }

    public function ubahStatus(Request $request){

        $id = $request->id;
        $status = $request->status;

        $tran = Transaksi::find($id);

        $tran->statusOrder_id = $status;

        if($tran->save()){
            $data['status'] = true;

            // $data['list'] = View_transaksi::groupBy('id')->get();
        }else{
            $data['status'] = false;
        }

        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    public function search(Request $request){
        $data['list'] = Transaksi::with('outlet', 'statusOrder', 'user')
                            ->whereRelation('outlet', 'nama', 'like', '%'.$request->param.'%')
                            ->orwhereRelation('outlet', 'alamat', 'like', '%'.$request->param.'%')
                            ->orwhereRelation('statusOrder', 'status', 'like', '%'.$request->param.'%')
                            ->orwhereRelation('user', 'name', 'like', '%'.$request->param.'%')
                            ->orwhere('kode_invoice', 'like', '%'.$request->param.'%')
                            ->orwhere('tgl', 'like', '%'.$request->param.'%')
                            ->orwhere('tgl_bayar', 'like', '%'.$request->param.'%')
                            ->orwhere('total', 'like', '%'.$request->param.'%')
                            ->orwhere('statusBayar', 'like', '%'.$request->param.'%')
                            ->orderBy('statusOrder_id','asc')->get();

        $data['param'] = $request->param;
        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    public function searchingKode(Request $request){
        $validate = Validator::make($request->all(),[
            'param' => 'required'
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['errors'] = $validate->errors();
        }else{
            
            $dat = Transaksi::with('outlet', 'user', 'detail_transaksi', 'statusOrder')->where('kode_invoice', '=', $request->param);

            if($dat->count() > 0){
                $data['status'] = true;
                $data['list'] = $dat->groupBy('id')->get();
            }else{
                $data['status'] = false;
            }
            
        }

        return json_encode($data);
    }


    public function bayar (Request $request){
        $validate = Validator::make($request->all(),[
            'id' => 'required',
            'dibayar' => 'required',
            'kode_invoice' => 'required',
            'total' => 'required',
            'tunai' => 'required',
            'kembalian' => 'required'
        ]);

        // return json_encode($request->all());

        if($validate->fails()){
            $data['validate'] = false;
            $data['errors'] = $validate->errors();
        }else{
            $data['validate'] = true;

            $det = Transaksi::find($request->id);

            $det->statusBayar = $request->dibayar;
            $det->tgl_bayar = date('Y-m-d');
            $det->tunai = $request->tunai;
            $det->kembalian = $request->kembalian;

            if($det->save()){
                $data['status'] = true;
                // $data['outlet'] = $request->outlet;
                $data['kode_invoice'] = $request->kode_invoice;
                $data['nama'] = $request->nama;
                $data['outlet'] = $request->outlet;
                $data['tgl_bayar'] = $det->tgl_bayar;
                $data['petugas'] = auth()->user()->name;
                $data['total'] = $request->total;
                $data['bayar'] = $request->tunai;
                $data['kembalian'] = $request->kembalian;
            }else{
                $data['status'] = false;
            }
        }

        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
