<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Stock ATK</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6a96cbff',
            cream: '#F5EFE6'
          }
        }
      }
    }
  </script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cream">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">

<!-- Header ATK -->
<div class="bg-primary px-6 py-6 text-white relative overflow-hidden">
  <div class="flex items-center gap-3 relative z-10">
    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-2xl">
      📎
    </div>
    <div>
      <h1 class="text-xl font-semibold leading-tight">
        Login Pengguna
      </h1>
      <p class="text-sm opacity-90">
        Sistem Stok ATK
      </p>
    </div>
  </div>

  <!-- dekorasi kanan atas -->
  <div class="absolute -right-2 -top-2 text-6xl opacity-30 select-none">
    📒
  </div>

  <!-- dekorasi kanan bawah -->
  <div class="absolute right-6 bottom-2 text-5xl opacity-25 select-none">
    🖊️
  </div>
</div>

    <!-- Body -->
    <div class="px-8 py-6">

      <p class="text-sm text-gray-600 mb-5">
        Silakan login menggunakan akun yang sudah terdaftar.
      </p>

      <!-- Alert -->
      @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 text-sm px-4 py-2">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 text-sm px-4 py-2">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm text-gray-700 mb-1">
            Email
          </label>
          <input type="email" name="email" required
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
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

        <button type="submit"
          class="w-full mt-2 rounded-lg bg-primary text-white py-2.5 text-sm font-semibold
                 hover:bg-opacity-90 transition flex items-center justify-center gap-2">
          🔐 Login
        </button>
      </form>

      <p class="text-center text-sm text-gray-600 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">
          Daftar sekarang
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