<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Stok Barang') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-light">

@if(Auth::check())
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Stok Barang</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('barang.index') }}">Barang</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('barang-masuk.index') }}">Barang Masuk</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('barang-keluar.index') }}">Barang Keluar</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm ms-2">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
@endif

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>
