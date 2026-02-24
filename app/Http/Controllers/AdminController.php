<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approve($id)
{
    $bk = BarangKeluar::findOrFail($id);

    if ($bk->status !== 'pending') return back();

    $bk->update(['status' => 'approved']);

    Barang::where('id', $bk->barang_id)
        ->decrement('stok', $bk->jumlah);

    return back()->with('success', 'Barang keluar disetujui');
}

// Di dalam AdminController.php
public function __construct()
{
    // Hanya user dengan role 'admin' yang bisa akses controller ini
    $this->middleware(function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda bukan Admin!');
        }
        return $next($request);
    });
}

}
