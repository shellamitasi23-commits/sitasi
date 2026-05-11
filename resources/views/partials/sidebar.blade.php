<aside style="width:220px; background:#fff; display:flex; flex-direction:column; min-height:100vh; flex-shrink:0; border-right:1px solid #e2e8f0;">

    {{-- Brand --}}
    <div style="padding:18px 16px 14px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px;">
        <div>
            <div style="color:#1e293b; font-size:13px; font-weight:600; line-height:1.3;">Tabungan Siswa TK</div>
            <div style="color:#94a3b8; font-size:10px; margin-top:1px;">Sistem Informasi</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav style="padding:10px; flex:1;">
        <div style="color:#94a3b8; font-size:9px; font-weight:600; padding:10px 8px 5px; text-transform:uppercase; letter-spacing:.08em;">Menu Utama</div>

        @php
            $navItem = 'display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:9px; font-size:13px; text-decoration:none; margin-bottom:2px;';
            $active  = 'background:#1e40af; color:#fff;';
            $normal  = 'color:#475569;';
            $iconActive = 'font-size:16px; color:#fff; flex-shrink:0;';
            $iconNormal = 'font-size:16px; color:#94a3b8; flex-shrink:0;';
        @endphp

        <a href="{{ route('dashboard') }}"
           style="{{ $navItem }} {{ request()->routeIs('dashboard') ? $active : $normal }}">
            <i class="ti ti-layout-dashboard"
               style="{{ request()->routeIs('dashboard') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Dashboard
        </a>

        <a href="{{ route('kelas.index') }}"
           style="{{ $navItem }} {{ request()->routeIs('kelas.*') ? $active : $normal }}">
            <i class="ti ti-school"
               style="{{ request()->routeIs('kelas.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Kelas
        </a>

        <a href="{{ route('siswa.index') }}"
           style="{{ $navItem }} {{ request()->routeIs('siswa.*') ? $active : $normal }}">
            <i class="ti ti-users"
               style="{{ request()->routeIs('siswa.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Siswa
        </a>

        <a href="{{ route('transaksi.index') }}"
           style="{{ $navItem }} {{ request()->routeIs('transaksi.*') ? $active : $normal }}">
            <i class="ti ti-arrows-exchange"
               style="{{ request()->routeIs('transaksi.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Transaksi
        </a>

        {{-- Divider --}}
        <div style="height:1px; background:#f1f5f9; margin:6px 4px;"></div>
        <div style="color:#94a3b8; font-size:9px; font-weight:600; padding:4px 8px 5px; text-transform:uppercase; letter-spacing:.08em;">Laporan</div>

        <a href="{{ route('laporan.index') }}"
           style="{{ $navItem }} {{ request()->routeIs('laporan.*') ? $active : $normal }}">
            <i class="ti ti-file-analytics"
               style="{{ request()->routeIs('laporan.*') ? $iconActive : $iconNormal }}" aria-hidden="true"></i>
            Laporan
        </a>
    </nav>

    {{-- User info + Logout --}}
    <div style="padding:10px; border-top:1px solid #f1f5f9;">
        <div style="display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:9px;">
            <div style="width:30px; height:30px; border-radius:8px; background:#1e40af; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; font-weight:600; flex-shrink:0;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div style="color:#1e293b; font-size:12px; font-weight:500;">{{ Auth::user()->name }}</div>
                <div style="color:#94a3b8; font-size:10px;">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="display:flex; align-items:center; gap:6px; color:#ef4444; font-size:12px; background:none; border:none; cursor:pointer; padding:7px 10px; border-radius:8px; width:100%;">
                <i class="ti ti-logout" style="font-size:14px;" aria-hidden="true"></i> Keluar
            </button>
        </form>
    </div>

</aside>