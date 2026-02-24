<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock ATK | Manajemen Alat Tulis Kantor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-white text-slate-900">

    {{-- NAVIGASI --}}
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-3xl">📦</span>
                <span class="text-xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-tight">Stock ATK</span>
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-slate-900 text-white rounded-full text-sm font-bold hover:bg-slate-800 transition">
                           Buka Panel Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-6 py-2.5 bg-blue-600 text-white rounded-full text-sm font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                               Daftar Akun
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="pt-40 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-block px-4 py-1.5 mb-6 bg-blue-50 border border-blue-100 rounded-full">
                    <span class="text-blue-600 text-xs font-bold tracking-widest uppercase">🚀 Modern Warehouse System</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold leading-[1.1] mb-6 tracking-tight">
                    Kelola Stok ATK <br> <span class="text-blue-600">Tanpa Ribet.</span>
                </h1>
                <p class="text-lg text-slate-500 mb-10 leading-relaxed max-w-lg">
                    Monitoring stok barang masuk dan keluar secara akurat. Dirancang khusus untuk mempermudah operasional kantor Anda setiap hari.
                </p>
                
                <div class="flex items-center gap-8 mb-10 border-l-4 border-blue-600 pl-6">
                    <div>
                        <p class="text-4xl font-extrabold text-slate-900">{{ $total_jenis }}</p>
                        <p class="text-sm text-slate-500 font-medium">Jenis Barang</p>
                    </div>
                    <div class="h-10 w-[1px] bg-slate-200"></div>
                    <div>
                        <p class="text-4xl font-extrabold text-slate-900">Aktif</p>
                        <p class="text-sm text-slate-500 font-medium">Real-time Monitor</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:scale-105 transition-transform shadow-xl">
                            Kembali ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold hover:scale-105 transition-transform shadow-xl shadow-blue-200">
                            Mulai Kelola Stok
                        </a>
                    @endauth
                </div>
            </div>

            {{-- KARTU STOK DINAMIS --}}
            <div class="relative hidden md:block">
                <div class="absolute -inset-4 bg-blue-100 rounded-full blur-3xl opacity-30 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-white to-slate-50 p-10 rounded-[48px] border border-slate-200 shadow-2xl">
                    <div class="space-y-6">
                        @foreach($stok_terbanyak as $index => $item)
                        <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 {{ $index % 2 != 0 ? 'translate-x-4' : '' }} hover:-translate-y-1 transition-all duration-300">
                            <div class="flex gap-3 items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-xl">📦</div>
                                <div class="font-bold text-slate-700 italic">{{ $item->nama }}</div>
                            </div>
                            <div class="text-blue-600 font-extrabold">{{ $item->stok }} {{ $item->satuan }}</div>
                        </div>
                        @endforeach

                        @if($stok_terendah)
                        <div class="flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 -translate-x-2 hover:-translate-y-1 transition-all duration-300">
                            <div class="flex gap-3 items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-xl">⚠️</div>
                                <div class="font-bold text-slate-700 italic">{{ $stok_terendah->nama }}</div>
                            </div>
                            <div class="text-red-500 font-extrabold flex flex-col items-end">
                                <span>{{ $stok_terendah->stok }} {{ $stok_terendah->satuan }}</span>
                                <span class="text-[10px] uppercase tracking-tighter bg-red-50 px-2 rounded font-bold">Menipis</span>
                            </div>
                        </div>
                        @endif {{-- <--- INI ADALAH PENUTUP YANG HILANG TADI --}}
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-100 flex justify-center">
                        <div class="h-2 w-24 bg-slate-200 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 text-center text-slate-500 text-sm">
            <p>&copy; 2025 Warehouse Solution. Build with Laravel.</p>
        </div>
    </footer>

</body>
</html>