<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }

    function katalog()
    {
        return $this->belongsTo(Katalog::class, 'katalog_id', 'id');
    }
}
