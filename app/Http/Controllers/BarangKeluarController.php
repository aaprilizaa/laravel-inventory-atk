<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB; // WAJIB ADA untuk DB::transaction

class BarangKeluarController extends Controller
{
    // TAMPILAN
    public function index()
    {
        return view('barang_keluar.index', [
            'barang' => Barang::all(),
            'data'   => BarangKeluar::with('barang', 'user')->latest()->get()
        ]);
    }

    // SIMPAN PERMINTAAN (USER)
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id', // Pastikan nama tabel benar (barangs atau barang)
            'jumlah'    => 'required|integer|min:1',
            'tanggal'   => 'required|date',
        ]);

        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'jumlah'    => $request->jumlah,
            'tanggal'   => $request->tanggal,
            'user_id'   => auth()->id(),
            'status'    => 'pending'
        ]);

        return back()->with('success', 'Permintaan barang keluar dikirim');
    }

    // APPROVE (ADMIN)
    public function approve($id)
    {
        return DB::transaction(function () use ($id) {
            // 1. Ambil data dengan Lock untuk keamanan
            $keluar = BarangKeluar::findOrFail($id);

            // 2. Cek jika sudah bukan pending
            if ($keluar->status !== 'pending') {
                return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
            }

            $barang = Barang::findOrFail($keluar->barang_id);

            // 3. Cek apakah stok cukup
            if ($barang->stok < $keluar->jumlah) {
                return back()->with('error', 'Stok barang tidak mencukupi untuk disetujui.');
            }

            // 4. Kurangi stok dan update status secara bersamaan
            $barang->decrement('stok', $keluar->jumlah);
            $keluar->update(['status' => 'approved']);

            return back()->with('success', 'Barang keluar disetujui dan stok dipotong.');
        });
    }

    // REJECT (ADMIN)
    public function reject($id)
    {
        $keluar = BarangKeluar::findOrFail($id);
        
        if ($keluar->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan pending yang bisa ditolak.');
        }

        $keluar->update(['status' => 'rejected']);
        return back()->with('info', 'Permintaan barang keluar ditolak.');
    }
}