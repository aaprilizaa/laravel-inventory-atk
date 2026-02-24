<?php

use Illuminate\Support\Facades\Route;
use App\Models\Barang; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman Depan)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Ambil 2 barang dengan stok terbanyak
    $stok_terbanyak = Barang::orderBy('stok', 'desc')->take(2)->get();
    
    // Ambil 1 barang dengan stok paling sedikit (untuk indikator menipis)
    $stok_terendah = Barang::orderBy('stok', 'asc')->first();

    // Hitung total jenis barang untuk statistik
    $total_jenis = Barang::count();

    // Pastikan nama file blade kamu benar (welcome atau home)
    return view('home', compact('stok_terbanyak', 'stok_terendah', 'total_jenis'));
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tambahkan rute PROFIL di sini agar link di dashboard tidak error
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. BARANG (Lengkap: Index, Store, Update, Destroy)
    Route::resource('barang', BarangController::class);

    // 3. BARANG MASUK (Hanya Admin)
    Route::resource('barang_masuk', BarangMasukController::class)->middleware('admin');

    // 4. BARANG KELUAR (User mengajukan, Admin approve/reject)
    Route::resource('barang_keluar', BarangKeluarController::class);

    // 5. KHUSUS ADMIN (Approve & Reject)
    Route::middleware('admin')->group(function () {
        Route::post('/barang_keluar/{id}/approve', [BarangKeluarController::class, 'approve'])
            ->name('barang_keluar.approve');
        
        Route::post('/barang_keluar/{id}/reject', [BarangKeluarController::class, 'reject'])
            ->name('barang_keluar.reject');
    });

});

require __DIR__.'/auth.php';