<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index', [
            'data' => Barang::latest()->get() // Mengurutkan dari yang terbaru
        ]);
    }

    public function store(Request $r)
    {
        // 1. Validasi WAJIB agar tidak error SQL 'Column cannot be null'
        $validated = $r->validate([
            'kode' => 'required|unique:barang,kode',
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        // 2. Gunakan $validated, jangan $r->all()
        Barang::create($validated);

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:barang,kode,' . $id,
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($validated);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            
            // Cek relasi agar database tidak error 'Constraint Violation'
            // Ganti 'barangMasuk' & 'barangKeluar' sesuai nama method di Model Barang kamu
            if($barang->barangMasuk()->exists() || $barang->barangKeluar()->exists()) {
                return redirect()->back()->with('error', 'Gagal hapus! Barang ini sudah memiliki riwayat transaksi.');
            }

            $barang->delete();
            return redirect()->back()->with('success', 'Barang berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}