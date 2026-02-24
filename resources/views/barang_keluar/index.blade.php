<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar | Stock ATK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex min-h-screen text-slate-800">

    <aside class="w-64 bg-white border-r border-slate-200 hidden md:block">
        <div class="p-6">
            <div class="flex items-center gap-2 font-bold text-xl text-blue-600">
                <span>📦</span> Stock ATK.
            </div>
        </div>
        <nav class="px-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition">
                📊 Dashboard
            </a>
            
            <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition">
                📦 Data Barang
            </a>

            @if(auth()->user()->role == 'admin')
            <a href="{{ route('barang_masuk.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition">
                📥 Barang Masuk
            </a>
            @endif

            <a href="{{ route('barang_keluar.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-semibold">
                📤 Barang Keluar
            </a>

            <div class="pt-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full text-red-500 hover:bg-red-50 rounded-xl transition font-medium">
                        🚪 Keluar Aplikasi
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Barang Keluar</h1>
                <p class="text-slate-500 text-sm">Kelola permintaan dan pengeluaran stok ATK.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 text-sm font-medium">
                📅 {{ date('d M Y') }}
            </div>
        </header>

        {{-- FORM INPUT: Khusus User untuk Mengajukan Permintaan --}}
        @if (auth()->user()->role === 'user')
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
            <h3 class="font-bold mb-4 text-slate-700 flex items-center gap-2">
                <span>📝</span> Ajukan Permintaan Barang
            </h3>
            <form action="{{ route('barang_keluar.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Pilih Barang</label>
                        <select name="barang_id" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }} (Sisa: {{ $b->stok }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Jumlah Dibutuhkan</label>
                        <input type="number" name="jumlah" placeholder="Contoh: 5" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Tanggal Keperluan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50" required>
                    </div>
                </div>

                <button type="submit" class="mt-6 px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                    🚀 Kirim Permintaan
                </button>
            </form>
        </div>
        @endif

        {{-- TABEL DATA --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h4 class="font-bold text-slate-700">Daftar Pengeluaran & Status</h4>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        @if (auth()->user()->role === 'admin')
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($data as $d)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700 block">{{ $d->barang->nama }}</span>
                            <span class="text-xs text-slate-400 font-medium">ID Transaksi: #OUT-{{ $d->id }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-slate-700">{{ $d->jumlah }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium text-sm">
                            {{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($d->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-[10px] font-bold uppercase tracking-wider italic">🕒 Pending</span>
                            @elseif ($d->status === 'approved')
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider italic">✅ Approved</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider italic">❌ Rejected</span>
                            @endif
                        </td>

                        {{-- ADMIN ACTION --}}
                        @if (auth()->user()->role === 'admin')
                        <td class="px-6 py-4 text-center">
                            @if($d->status === 'pending')
                            <div class="flex justify-center gap-2">
                                <form action="{{ route('barang_keluar.approve', $d->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition shadow-sm shadow-green-200">Approve</button>
                                </form>
                                <form action="{{ route('barang_keluar.reject', $d->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-sm shadow-red-200">Reject</button>
                                </form>
                            </div>
                            @else
                                <span class="text-slate-300 text-xs italic">Selesai</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada riwayat permintaan barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Perhatian!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });
        @endif
    </script>
</body>
</html>