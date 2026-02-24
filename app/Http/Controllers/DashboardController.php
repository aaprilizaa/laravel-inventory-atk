<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Barang, BarangMasuk, BarangKeluar};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data yang muncul untuk semua role
        $data = [
            'total_barang'  => Barang::count(),
            'stok_menipis'  => Barang::where('stok', '<=', 5)->count(),
            'barang_masuk'  => BarangMasuk::whereDate('created_at', today())->count(),
            'latest_stocks' => Barang::where('stok', '<=', 5)->orderBy('stok', 'asc')->take(5)->get()
        ];

        // Logika Khusus Admin
        if ($user->role === 'admin') {
            $data['jumlah_pending'] = BarangKeluar::where('status', 'pending')->count();
        } 
        // Logika Khusus User
        else {
            $data['my_recent_requests'] = BarangKeluar::where('user_id', $user->id)
                                          ->with('barang')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            
            $data['total_permintaan_user'] = BarangKeluar::where('user_id', $user->id)
                                             ->whereMonth('created_at', now()->month)
                                             ->count();
        }

        return view('dashboard', $data);
    }
}