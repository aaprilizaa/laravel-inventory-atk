<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang | Stock ATK</title>
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
            
            <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-xl font-semibold">
                📦 Data Barang
            </a>

            @if(auth()->user()->role == 'admin')
            <a href="{{ route('barang_masuk.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition">
                📥 Barang Masuk
            </a>
            @endif

            <a href="{{ route('barang_keluar.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-100 rounded-xl transition">
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
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Data Barang</h1>
                <p class="text-slate-500 text-sm">Kelola daftar stok barang ATK Anda di sini.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 text-sm font-medium">
                📅 {{ date('d M Y') }}
            </div>
        </header>

        {{-- FORM TAMBAH BARANG: Hanya muncul untuk Admin --}}
        @if(auth()->user()->role == 'admin')
        <div class="mb-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="font-bold mb-4 text-slate-700 flex items-center gap-2">
                <span>✨</span> Tambah Barang Baru
            </h3>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Kode Barang</label>
                        <input type="text" name="kode" placeholder="Contoh: BRG-001" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Nama Barang</label>
                        <input type="text" name="nama" placeholder="Nama Barang" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Stok Awal</label>
                        <input type="number" name="stok" placeholder="Jumlah" class="w-full border border-slate-200 p-2.5 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                </div>
                <button type="submit" class="mt-4 px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                    + Simpan Barang
                </button>
            </form>
        </div>
        @else
        <div class="mb-8 p-4 bg-blue-50 text-blue-700 rounded-2xl border border-blue-100 flex items-center gap-3">
            <span>ℹ️</span>
            <p class="text-sm font-medium">Anda masuk sebagai <strong>User</strong>. Fitur tambah, edit, dan hapus dinonaktifkan.</p>
        </div>
        @endif

        {{-- TABEL DATA --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Tersedia</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($data as $b)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-semibold text-blue-600">{{ $b->kode }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700">{{ $b->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 {{ $b->stok <= 5 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }} rounded-full text-xs font-bold">
                                {{ $b->stok }} Unit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(auth()->user()->role == 'admin')
                            <div class="flex justify-center gap-3">
                                <button onclick="openEditModal('{{ $b->id }}', '{{ $b->kode }}', '{{ $b->nama }}', '{{ $b->stok }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    ✏️ <span class="text-xs font-bold ml-1 uppercase">Edit</span>
                                </button>
                                <button onclick="confirmDelete('{{ $b->id }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    🗑️ <span class="text-xs font-bold ml-1 uppercase">Hapus</span>
                                </button>
                            </div>
                            <form id="delete-form-{{ $b->id }}" action="{{ route('barang.destroy', $b->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            @else
                            <span class="text-slate-400 text-xs italic font-medium">Hanya Lihat</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-50 items-center justify-center flex">
        <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-800 font-inter">Perbarui Data</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Kode Barang</label>
                        <input type="text" id="edit_kode" name="kode" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Nama Barang</label>
                        <input type="text" id="edit_nama" name="nama" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase ml-1">Stok</label>
                        <input type="number" id="edit_stok" name="stok" class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, kode, nama, stok) {
            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('editForm').action = `/barang/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Barang?',
                text: "Data ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-xl px-6 py-2 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", timer: 2500, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });
        @endif
    </script>
</body>
</html>