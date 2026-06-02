<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriObat extends Model
{
    protected $table = 'kategori_obat';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }
}