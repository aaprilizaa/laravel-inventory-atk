<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar; // <-- Jangan lupa import model ini

class UserController extends Controller
{
    public function store(Request $r)
    {
        // Pastikan nama tabel/model sesuai
        BarangKeluar::create([
            'barang_id' => $r->barang_id,
            'user_id'   => auth()->id(), // Ini mengambil ID user yang sedang login
            'jumlah'    => $r->jumlah,
            'tanggal'   => now(),
            'status'    => 'pending'
        ]);

        return back()->with('success', 'Permintaan barang dikirim');
    }
}
