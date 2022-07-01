<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    use HasFactory;

    public function transaksi (){
        return $this->hasMany(Transaksi::class, 'statusOrder_id', 'id');
    }
}
