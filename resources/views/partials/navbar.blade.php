<header class="bg-white border-b border-slate-200 px-5 h-14 flex items-center gap-3 shrink-0">

    {{-- Search --}}
    <form action="{{ route('siswa.index') }}" method="GET" class="flex-1 flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-3 h-9">
        <i class="ti ti-search text-slate-400 text-base shrink-0" aria-hidden="true"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau kelas..." 
               class="border-none bg-transparent outline-none text-sm text-slate-700 w-full placeholder:text-slate-400 focus:ring-0">
    </form>

</header>