<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil | Stock ATK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-2 mb-2">
                    ⬅️ Kembali ke Dashboard
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Pengaturan Profil</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-8">
            
            <div class="bg-white shadow-sm border border-slate-200 rounded-3xl p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-800">Informasi Profil</h2>
                    <p class="text-sm text-slate-500">Perbarui nama dan alamat email akun Anda.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm border border-slate-200 rounded-3xl p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-800">Ganti Password</h2>
                    <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
                </div>

                <form method="post" action="{{ route('profile.password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <button type="submit" class="px-6 py-3 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 shadow-lg transition active:scale-95">
                        Ganti Password
                    </button>
                </form>
            </div>

            <div class="bg-red-50 shadow-sm border border-red-100 rounded-3xl p-8">
                <h2 class="text-xl font-bold text-red-800 mb-2">Zona Berbahaya</h2>
                <p class="text-sm text-red-600 mb-6 font-medium">Sekali Anda menghapus akun, semua data akan hilang secara permanen.</p>
                
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="mb-4 max-w-sm">
                        <label class="block text-sm font-bold text-red-800 mb-2">Masukkan Password untuk Konfirmasi</label>
                        <input type="password" name="password" placeholder="Password Konfirmasi" class="w-full px-4 py-3 rounded-xl border border-red-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition" required>
                    </div>

                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-100 transition active:scale-95">
                        Hapus Akun Permanen
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>