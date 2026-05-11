<aside class="w-56 bg-white flex flex-col min-h-screen shrink-0 border-r border-slate-200">

    {{-- Brand --}}
    <div class="pt-4 pb-3.5 px-4 border-b border-slate-100 flex items-center gap-2.5">
        <div>
            <div class="text-slate-800 text-sm font-semibold leading-tight">Tabungan Siswa TK</div>
            <div class="text-slate-400 text-[10px] mt-0.5">Sistem Informasi</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="p-2.5 flex-1">
        <div class="text-slate-400 text-[9px] font-semibold pt-2.5 pb-1.5 px-2 uppercase tracking-widest">Menu Utama</div>

        @php
            $navItem = 'flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] no-underline mb-0.5 transition-colors';
            $active  = 'bg-blue-800 text-white';
            $normal  = 'text-slate-600 hover:bg-slate-50';
            $iconActive = 'text-base text-white shrink-0';
            $iconNormal = 'text-base text-slate-400 shrink-0';
        @endphp

        <a href="{{ route('dashboard') }}"
           class="{{ $navItem }} {{ request()->routeIs('dashboard') ? $active : $normal }}">
            <i class="ti ti-layout-dashboard {{ request()->routeIs('dashboard') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Dashboard
        </a>

        <a href="{{ route('kelas.index') }}"
           class="{{ $navItem }} {{ request()->routeIs('kelas.*') ? $active : $normal }}">
            <i class="ti ti-school {{ request()->routeIs('kelas.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Kelas
        </a>

        <a href="{{ route('siswa.index') }}"
           class="{{ $navItem }} {{ request()->routeIs('siswa.*') ? $active : $normal }}">
            <i class="ti ti-users {{ request()->routeIs('siswa.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Siswa
        </a>

        <a href="{{ route('transaksi.index') }}"
           class="{{ $navItem }} {{ request()->routeIs('transaksi.*') ? $active : $normal }}">
            <i class="ti ti-arrows-exchange {{ request()->routeIs('transaksi.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Transaksi
        </a>

        {{-- Divider --}}
        <div class="h-px bg-slate-100 my-1.5 mx-1"></div>
        <div class="text-slate-400 text-[9px] font-semibold pt-1 pb-1.5 px-2 uppercase tracking-widest">Laporan</div>

        <a href="{{ route('laporan.index') }}"
           class="{{ $navItem }} {{ request()->routeIs('laporan.*') ? $active : $normal }}">
            <i class="ti ti-file-analytics {{ request()->routeIs('laporan.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Laporan
        </a>
    </nav>

    {{-- User info + Logout --}}
    <div class="p-2.5 border-t border-slate-100">
        <div class="flex items-center gap-2 px-2.5 py-2 rounded-lg hover:bg-slate-50 transition-colors">
            <div class="w-8 h-8 rounded-lg bg-blue-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="truncate">
                <div class="text-slate-800 text-xs font-medium truncate">{{ Auth::user()->name }}</div>
                <div class="text-slate-400 text-[10px]">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="w-full flex items-center gap-1.5 text-rose-500 text-xs bg-transparent border-none cursor-pointer px-2.5 py-2 rounded-lg hover:bg-rose-50 transition-colors">
                <i class="ti ti-logout text-sm" aria-hidden="true"></i> Keluar
            </button>
        </form>
    </div>

</aside>