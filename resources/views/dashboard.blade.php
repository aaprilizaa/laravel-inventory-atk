<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Stock ATK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
        <div class="p-6 text-center md:text-left">
            <div class="flex items-center gap-2 font-bold text-xl text-blue-600">
                <span>📦</span> Stock ATK
            </div>
        </div>
        
        <nav class="px-4 flex-1 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-600 hover:bg-slate-100' }} rounded-xl transition font-medium">
                📊 Dashboard
            </a>
            
            <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition font-medium">
                📦 Data Barang
            </a>

            @if (auth()->user()->role == 'admin')
            <a href="{{ route('barang_masuk.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition font-medium">
                📥 Barang Masuk
            </a>
            @endif

            <a href="{{ route('barang_keluar.index') }}" class="flex items-center justify-between px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition font-medium">
                <div class="flex items-center gap-3">
                    <span>📤</span> Barang Keluar
                </div>
                @if (auth()->user()->role == 'admin' && ($jumlah_pending ?? 0) > 0)
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-[10px] font-bold text-white animate-pulse">
                        {{ $jumlah_pending }}
                    </span>
                @endif
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full text-red-500 hover:bg-red-50 rounded-lg transition text-sm font-semibold">
                    🚪 Keluar Aplikasi
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8">
        
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h1>
                <p class="text-slate-500 text-sm">Pantau ketersediaan stok ATK Anda di sini.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 text-sm font-medium text-slate-600 flex items-center gap-2">
                <span>📅</span> {{ date('d M Y') }}
            </div>
        </header>

        <section class="mb-10">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <div class="w-20 h-20 rounded-2xl {{ auth()->user()->role == 'admin' ? 'bg-blue-600' : 'bg-emerald-600' }} flex items-center justify-center text-3xl text-white font-black shadow-lg shadow-blue-100">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-white p-1.5 rounded-lg shadow-md border border-slate-100 text-xs">
                        {!! auth()->user()->role == 'admin' ? '🛡️' : '👤' !!}
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                        <h2 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                        <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ auth()->user()->role == 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ auth()->user()->role }} Account
                        </span>
                    </div>
                    <p class="text-slate-500 text-sm">{{ auth()->user()->email }}</p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-200 transition active:scale-95">
                        Pengaturan Profil
                    </a>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Total Jenis Barang</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $total_barang }}</h3>
            </div>
            
            @if(auth()->user()->role == 'admin')
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Masuk Hari Ini</p>
                <h3 class="text-3xl font-black text-blue-600">{{ $barang_masuk }}</h3>
            </div>
            @else
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Status Terakhir Anda</p>
                @php $last = $my_recent_requests->first() ?? null; @endphp
                @if($last)
                    <h3 class="text-xl font-black {{ $last->status == 'approved' ? 'text-emerald-600' : ($last->status == 'pending' ? 'text-orange-500' : 'text-red-500') }}">
                        {{ strtoupper($last->status) }}
                    </h3>
                @else
                    <h3 class="text-xl font-bold text-slate-300 italic">BELUM ADA DATA</h3>
                @endif
            </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Stok Menipis (≤ 5)</p>
                <h3 class="text-3xl font-black text-red-500">{{ $stok_menipis }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                    ⚠️ Stok Hampir Habis
                </h4>
                <div class="space-y-3">
                    @forelse($latest_stocks as $item)
                    <div class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <span class="font-bold text-slate-700 block">{{ $item->nama }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $item->kode_barang ?? 'No Code' }}</span>
                        </div>
                        <span class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-xs font-black">
                            {{ $item->stok }} tersisa
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <span class="text-4xl block mb-2">✅</span>
                        <p class="text-slate-400 text-sm italic">Semua stok tersedia dengan cukup.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if (auth()->user()->role == 'admin')
            <div class="bg-blue-600 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden flex flex-col justify-center border-4 border-blue-500">
                <div class="relative z-10">
                    <h4 class="text-2xl font-black mb-3 italic tracking-tight uppercase text-white">Update Stok?</h4>
                    <p class="text-blue-100 mb-6 text-sm leading-relaxed max-w-xs">Pastikan ketersediaan ATK kantor selalu terpenuhi dengan input stok baru.</p>
                    <a href="{{ route('barang_masuk.index') }}" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-2xl font-black shadow-lg hover:shadow-2xl transition-all active:scale-95 text-center">
                        INPUT STOK BARU
                    </a>
                </div>
                <span class="absolute -right-10 -bottom-10 text-[180px] opacity-10 rotate-12 pointer-events-none select-none italic font-black">IN</span>
            </div>
            @else
            <div class="bg-emerald-600 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden flex flex-col justify-center border-4 border-emerald-500">
                <div class="relative z-10">
                    <h4 class="text-2xl font-black mb-3 italic tracking-tight uppercase text-white">Minta Barang?</h4>
                    <p class="text-emerald-100 mb-6 text-sm leading-relaxed max-w-xs">Ajukan permintaan ATK dengan mudah melalui formulir elektronik kami.</p>
                    <a href="{{ route('barang_keluar.index') }}" class="inline-block bg-white text-emerald-600 px-8 py-4 rounded-2xl font-black shadow-lg hover:shadow-2xl transition-all active:scale-95 text-center">
                        BUAT PERMINTAAN
                    </a>
                </div>
                <span class="absolute -right-10 -bottom-10 text-[180px] opacity-10 rotate-12 pointer-events-none select-none italic font-black">OUT</span>
            </div>
            @endif
        </div>
    </main>

</body>
</html>