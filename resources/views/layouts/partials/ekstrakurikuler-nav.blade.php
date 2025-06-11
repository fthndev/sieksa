@php
    $baseLinkClass = 'px-3 py-2 text-sm font-medium border-b-2 transition-colors duration-150';
    $activeLinkClass = 'border-red-600 text-red-600 dark:text-red-400 font-semibold';
    $inactiveLinkClass = 'border-transparent text-slate-600 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-600 hover:text-slate-800 dark:hover:text-slate-200';
@endphp

<div class="flex justify-center sm:justify-start pt-1 gap-2 sm:gap-5 border-b border-slate-200 dark:border-slate-700 px-4 sm:px-6 lg:px-8">
    
    <a href="{{ route('ekstrakurikuler.detail', $ekskul) }}" class="{{ $baseLinkClass }} {{ request()->routeIs('ekstrakurikuler.detail') ? $activeLinkClass : $inactiveLinkClass }}">
       <i class="fas fa-info-circle sm:me-2"></i><span class="hidden sm:inline">Detail</span>
    </a>
    <a href="#" class="{{ $baseLinkClass }} {{-- ... --}}">
       <i class="fas fa-users sm:me-2"></i><span class="hidden sm:inline">Anggota</span>
    </a>
    @if(Auth::user()->hasRole('pj'))
        <a href="{{ route('pj.absensi.kelola', $ekskul) }}" class="{{ $baseLinkClass }} {{ request()->routeIs('pj.absensi.kelola') ? $activeLinkClass : $inactiveLinkClass }}">
           <i class="fas fa-qrcode sm:me-2"></i><span class="hidden sm:inline">Kelola Absensi</span>
        </a>
    @elseif(Auth::user()->hasRole('warga') || Auth::user()->hasRole('musahil'))
        <a href="{{ route('absensi.scan') }}" class="{{ $baseLinkClass }} {{ request()->routeIs('absensi.scan') ? $activeLinkClass : $inactiveLinkClass }}">
           <i class="fas fa-camera sm:me-2"></i><span class="hidden sm:inline">Lakukan Absensi</span>
        </a>
    @endif
</div>