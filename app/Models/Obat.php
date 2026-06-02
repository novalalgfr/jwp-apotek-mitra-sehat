<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'kategori_id',
        'nama_obat',
        'satuan',
        'stok',
        'status',
    ];

    public static function updateStatus(int $id): void
    {
        $obat = self::find($id);
        if ($obat) {
            $obat->status = $obat->stok > 0 ? 'tersedia' : 'tidak tersedia';
            $obat->save();
        }
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }

    public function obatMasuk()
    {
        return $this->hasMany(ObatMasuk::class, 'obat_id');
    }

    public function obatKeluar()
    {
        return $this->hasMany(ObatKeluar::class, 'obat_id');
    }
}