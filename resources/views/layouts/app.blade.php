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
<body class="m-0 font-sans bg-slate-100 text-slate-800 antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Navbar --}}
            @include('partials.navbar')

            {{-- Konten --}}
            <main class="flex-1 p-6 overflow-y-auto">
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