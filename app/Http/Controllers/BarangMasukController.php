<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\DB; // Tambahkan ini

class BarangMasukController extends Controller
{
    public function index()
    {
        return view('barang_masuk.index', [
            'barang' => Barang::all(),
            // Mengurutkan agar data terbaru muncul di atas
            'data' => BarangMasuk::with('barang')->latest()->get()
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date'
        ]);

        // Gunakan Transaction agar jika salah satu gagal, semua dibatalkan
        DB::beginTransaction();

        try {
            // 1. Simpan transaksi
            BarangMasuk::create($request->all());

            // 2. Update stok barang
            $barang = Barang::findOrFail($request->barang_id);
            $barang->stok += $request->jumlah;
            $barang->save();

            DB::commit(); // Simpan perubahan permanen
            return redirect()->back()->with('success', 'Stok berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua jika ada error
            return redirect()->back()->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }
}
