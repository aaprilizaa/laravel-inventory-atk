<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    // WAJIB: Daftarkan kolom yang bisa diisi
    protected $fillable = [
        'kode',
        'nama',
        'stok',
    ];
    
    // Jika kamu punya relasi ke BarangMasuk/Keluar, tambahkan juga
    public function barangMasuk() {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar() {
        return $this->hasMany(BarangKeluar::class);
    }
}