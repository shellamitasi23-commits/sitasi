<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tabungan Siswa TK')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    @stack('styles')
</head>
<body style="margin:0; font-family:sans-serif; background:#f1f5f9;">

    <div style="display:flex; min-height:100vh;">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main --}}
        <div style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Konten --}}
            <main style="flex:1; padding:24px; overflow-y:auto;">
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('partials.footer')

        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')

</body>
</html>