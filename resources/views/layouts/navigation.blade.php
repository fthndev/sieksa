{{-- resources/views/layouts/navigation.blade.php --}}
{{-- Variabel 'open' di sini adalah untuk dropdown menu pengguna, sedangkan 'sidebarOpen' dari scope parent (app.blade.php) adalah untuk sidebar utama --}}
<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900/95 backdrop-blur-sm border-b border-slate-200 dark:border-slate-700 sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center md:hidden -ms-2 me-3"> {{-- Diberi margin agar tidak terlalu rapat --}}
                    <button @click="sidebarOpen = !sidebarOpen" {{-- Menggunakan sidebarOpen dari parent scope --}}
                            title="Buka navigasi samping"
                            class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-slate-800 focus:outline-none focus:bg-red-100 dark:focus:bg-slate-800 focus:text-red-600 dark:focus:text-red-400 transition duration-150 ease-in-out">
                        <i class="fas fa-bars text-xl"></i>
                        <span class="sr-only">Buka navigasi utama</span>
                    </button>
                </div>

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-red-700 dark:text-red-500">
                        SIEKSAd
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $isActiveDashboard = request()->routeIs('dashboard');
                        $dashboardClasses = $isActiveDashboard
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-red-600 dark:border-red-500 text-sm font-semibold leading-5 text-red-700 dark:text-red-400 focus:outline-none focus:border-red-700 transition duration-150 ease-in-out'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-600 dark:text-slate-400 hover:text-red-700 dark:hover:text-red-400 hover:border-red-300 dark:hover:border-red-600 focus:outline-none focus:text-red-700 focus:border-red-300 transition duration-150 ease-in-out';
                    @endphp
                    <a href="{{ route('dashboard') }}" class="{{ $dashboardClasses }}">
                        <i class="fas fa-tachometer-alt me-2 opacity-75"></i>
                        {{ __('Dashboard') }}
                    </a>
                    {{-- Anda bisa menambahkan link navigasi desktop lainnya di sini jika perlu --}}
                </div>
            </div>

            <div class="flex items-center"> {{-- Wrapper untuk item kanan --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900/0 hover:text-red-700 dark:hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition ease-in-out duration-150">
                                <img class="h-8 w-8 rounded-full me-2 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=random&color=fff&bold=true" alt="{{ Auth::user()->nama }}">
                                <div>{{ Auth::user()->nama }}</div>
                                <div class="ms-1">
                                    <i class="fas fa-chevron-down text-xs opacity-70"></i>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-50 dark:hover:bg-red-800/50 focus:bg-red-50 dark:focus:bg-red-800/50 hover:text-red-700 dark:hover:text-red-400">
                                <i class="fas fa-user-edit w-5 me-2 opacity-70"></i>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="hover:bg-red-50 dark:hover:bg-red-800/50 focus:bg-red-50 dark:focus:bg-red-800/50 hover:text-red-700 dark:hover:text-red-400">
                                    <i class="fas fa-sign-out-alt w-5 me-2 opacity-70"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" {{-- 'open' ini adalah state lokal untuk dropdown settings --}}
                            title="Buka menu pengguna"
                            class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-slate-800 focus:outline-none focus:bg-red-100 dark:focus:bg-slate-800 focus:text-red-600 dark:focus:text-red-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 dark:border-slate-700">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Link Dashboard di responsive menu, jika Anda ingin menampilkannya juga di sini --}}
            @php
                $isActiveDashboardResponsive = request()->routeIs('dashboard');
                $dashboardResponsiveClasses = $isActiveDashboardResponsive
                    ? 'flex items-center ps-3 pe-4 py-2 border-l-4 border-red-600 dark:border-red-500 text-base font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/30 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700 transition duration-150 ease-in-out'
                    : 'flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 dark:text-slate-400 hover:text-red-700 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-slate-800 hover:border-red-300 dark:hover:border-red-600 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700 transition duration-150 ease-in-out';
            @endphp
            <a href="{{ route('dashboard') }}" class="{{ $dashboardResponsiveClasses }}">
                <i class="fas fa-tachometer-alt me-3 w-5 text-center opacity-75"></i>
                {{ __('Dashboard') }}
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200 dark:border-slate-600">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                 @php
                    $profileResponsiveClasses = request()->routeIs('profile.edit')
                        ? 'flex items-center ps-3 pe-4 py-2 border-l-4 border-red-600 dark:border-red-500 text-base font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/30 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700 transition duration-150 ease-in-out'
                        : 'flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 dark:text-slate-400 hover:text-red-700 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-slate-800 hover:border-red-300 dark:hover:border-red-600 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700 transition duration-150 ease-in-out';
                @endphp
                <a href="{{ route('profile.edit') }}" class="{{ $profileResponsiveClasses }}">
                    <i class="fas fa-user-edit me-3 w-5 text-center opacity-75"></i>
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-600 dark:text-slate-400 hover:text-red-700 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-slate-800 hover:border-red-300 dark:hover:border-red-600 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700 transition duration-150 ease-in-out">
                        <i class="fas fa-sign-out-alt me-3 w-5 text-center opacity-75"></i>
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>