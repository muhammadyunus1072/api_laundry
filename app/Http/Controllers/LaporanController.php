<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Outlet;
use App\Models\Paket;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        //
        $data['outlet'] = Outlet::all();
        $data['role'] = Role::all();

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
        if($request->table == "outlet"){
            $data['list'] = Outlet::all();
        }
        if($request->table == "paket"){
            if($request->outlet == "semua"){
                $data['list'] = Paket::all();
            }else{
                $data['list'] = Paket::where('id_outlet', '=', $request->outlet)->get();
            }
        }
        if($request->table == "user"){
            if($request->role == "semua"){
                $data['list'] = User::with('role')->get();
            }else if($request->role != "semua"){
                $data['list'] = User::with('role')->whereRelation('role','id', '=', $request->role)->get();
            }
        }
        if($request->table == "transaksis"){
            // ===
            if($request->outlet == "semua" && $request->tanggal == "semua" && $request->bayar == "semua" ){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->groupBy('id')->get();
            }
            // !!=
            else if($request->outlet != "semua" && $request->tanggal != "semua" && $request->bayar == "semua" ){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('tgl', '=', $request->tanggal)->groupBy('id')->get();                
            }
            // ==!
            else if($request->outlet == "semua" && $request->tanggal == "semua" && $request->bayar != "semua"){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('tgl_bayar', '=', $request->bayar)->groupBy('id')->get();
            }
            // !==
            else if($request->outlet != "semua" && $request->tanggal == "semua" && $request->bayar == "semua" ){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('outlet_id', '=', $request->outlet)->groupBy('id')->get();
            }
            // !=!
            else if($request->outlet != "semua" && $request->tanggal == "semua" && $request->bayar != "semua"){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('outlet_id', '=', $request->outlet)->where('tgl_bayar', '=', $request->bayar)->groupBy('id')->get();
            }
            // =!=
            else if($request->outlet == "semua" && $request->tanggal != "semua" && $request->bayar == "semua" ){
                // return json_encode($request->all());
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('tgl', '=', $request->tanggal)->groupBy('id')->get();
            }
            // =!!
            else if($request->outlet == "semua" && $request->tanggal != "semua" && $request->bayar != "semua"){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('tgl', '=', $request->tanggal)->where('tgl_bayar', '=', $request->bayar)->groupBy('id')->get();
            }
            // !!!
            else if($request->outlet != "semua" && $request->tanggal != "semua" && $request->bayar != "semua"){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('outlet_id', '=', $request->outlet)->where('tgl', '=', $request->tanggal)->where('tgl_bayar', '=', $request->bayar)->groupBy('id')->get();
            }
            // =!!
            else if($request->outlet == "semua" && $request->tanggal != "semua" && $request->bayar != "semua"){
                $data['list'] = Transaksi::with('user', 'outlet', 'statusOrder')->where('tgl', '=', $request->tanggal)->where('tgl_bayar', '=', $request->bayar)->groupBy('id')->get();
            }
        }

        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
