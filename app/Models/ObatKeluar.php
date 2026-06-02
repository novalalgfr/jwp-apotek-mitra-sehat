<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObatKeluar extends Model
{
    protected $table = 'obat_keluar';

    protected $fillable = ['obat_id', 'tanggal', 'jumlah', 'keterangan'];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}