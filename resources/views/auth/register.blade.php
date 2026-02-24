<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Stock ATK</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6D94C5',
            cream: '#F5EFE6'
          }
        }
      }
    }
  </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cream p-4">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">

    <div class="bg-primary px-6 py-6 text-white relative">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-2xl">
          ✏️
        </div>
        <div>
          <h1 class="text-xl font-semibold leading-tight">
            Registrasi Pengguna
          </h1>
          <p class="text-sm opacity-90">
            Sistem Stok ATK
          </p>
        </div>
      </div>

      <div class="absolute right-4 top-4 text-2xl opacity-20">📘</div>
      <div class="absolute right-10 bottom-2 text-xl opacity-20">📐</div>
    </div>

    <div class="px-8 py-6">

      <p class="text-sm text-gray-600 mb-5">
        Silakan lengkapi data di bawah untuk membuat akun baru.
      </p>

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm text-gray-700 mb-1">
            Nama Lengkap
          </label>
          <input type="text" name="name" required
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
        </div>

        <div>
          <label class="block text-sm text-gray-700 mb-1">
            Email
          </label>
          <input type="email" name="email" required
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
        </div>

        <div>
          <label class="block text-sm text-gray-700 mb-1 font-medium">
            Level Pengguna
          </label>
          <select name="role" required
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary bg-white">
            <option value="" disabled selected>Pilih Level...</option>
            <option value="user">User (Staf/Pemohon)</option>
            <option value="admin">Admin (Pengelola Stok)</option>
          </select>
        </div>

        <div>
          <label class="block text-sm text-gray-700 mb-1">
            Password
          </label>
          <div class="relative">
            <input id="password" type="password" name="password" required
              class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm
                     focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
            <button type="button"
              onclick="togglePassword('password', this)"
              class="absolute inset-y-0 right-3 text-gray-400 text-sm">
              👁️
            </button>
          </div>
        </div>

        <div>
          <label class="block text-sm text-gray-700 mb-1">
            Konfirmasi Password
          </label>
          <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" required
              class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm
                     focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
            <button type="button"
              onclick="togglePassword('password_confirmation', this)"
              class="absolute inset-y-0 right-3 text-gray-400 text-sm">
              👁️
            </button>
          </div>
        </div>

        <button type="submit"
          class="w-full mt-2 rounded-lg bg-primary text-white py-2.5 text-sm font-semibold
                 hover:bg-opacity-90 transition flex items-center justify-center gap-2">
          🗂️ Daftar Akun
        </button>
      </form>

      <p class="text-center text-sm text-gray-600 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">
          Login
        </a>
      </p>

    </div>
  </div>

<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
      input.type = 'text';
      btn.textContent = '🙈';
    } else {
      input.type = 'password';
      btn.textContent = '👁️';
    }
  }
</script>

</body>
</html>