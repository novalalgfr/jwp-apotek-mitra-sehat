<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    protected $table = 'obat_masuk';

    protected $fillable = ['obat_id', 'tanggal', 'jumlah', 'keterangan'];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}