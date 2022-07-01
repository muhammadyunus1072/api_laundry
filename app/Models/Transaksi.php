<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function outlet(){
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detail_transaksi(){
        return $this->hasMany(DetailTransaksi::class);
    }

    public function statusOrder(){
        return $this->belongsTo(StatusOrder::class, 'statusOrder_id', 'id');
    }
}
