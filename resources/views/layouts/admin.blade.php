<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ __('messages.page_direction') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.dashboard')) | Smart Edu</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.25s ease-in-out;
        }

        [dir="rtl"] .sidebar-translate {
            transform: translateX(100%);
        }

        [dir="ltr"] .sidebar-translate {
            transform: translateX(-100%);
        }

        .sidebar-visible {
            transform: translateX(0) !important;
        }

        .nav-active {
            @apply bg-blue-50 text-blue-600 font-bold border-{{ __('messages.page_direction') == 'rtl' ? 'l' : 'r' }}-4 border-blue-600;
        }

        @layer utilities {
            .tracking-tighter {
                letter-spacing: -0.05em;
            }
        }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body class="bg-[#f8fafc] text-[#334155] min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 z-50 w-72 bg-white border-{{ __('messages.page_direction') == 'rtl' ? 'l' : 'r' }} border-gray-100 sidebar-transition sidebar-translate md:translate-x-0 md:static md:block shadow-sm">
            <div class="flex flex-col h-full">
                <!-- Branding -->
                <div class="px-8 py-10 border-b border-gray-50 mb-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                            <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h1 class="font-black text-gray-900 text-xl tracking-tighter leading-none">Smart Edu</h1>
                            <p class="text-[9px] text-gray-400 uppercase font-bold tracking-widest mt-1">Management Hub
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Nav -->
                <nav class="flex-1 px-4 space-y-1.5">
                    <a href="{{route('admin.index')}}"
                        class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all {{ request()->routeIs('admin.index') ? 'bg-blue-50 text-blue-600 font-bold border-' . (__('messages.page_direction') == 'rtl' ? 'l' : 'r') . '-4 border-blue-600 shadow-sm' : 'text-gray-500 hover:text-blue-600 hover:bg-gray-50' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="text-sm tracking-tight">{{__('messages.dashboard')}}</span>
                    </a>

                    <div class="pt-8 pb-3 px-5">
                        <span
                            class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">{{ __('messages.management') ?? 'Management' }}</span>
                    </div>

                    <a href="{{route('admin.teacher.index')}}"
                        class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all {{ request()->routeIs('admin.teacher.*') ? 'bg-blue-50 text-blue-600 font-bold border-' . (__('messages.page_direction') == 'rtl' ? 'l' : 'r') . '-4 border-blue-600 shadow-sm' : 'text-gray-500 hover:text-blue-600 hover:bg-gray-50 group' }}">
                        <i data-lucide="users" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm tracking-tight">{{__('messages.teachers')}}</span>
                    </a>

                    <a href="{{route('admin.student.index')}}"
                        class="flex items-center gap-3.5 px-5 py-3.5 rounded-xl transition-all {{ request()->routeIs('admin.student.*') ? 'bg-blue-50 text-blue-600 font-bold border-' . (__('messages.page_direction') == 'rtl' ? 'l' : 'r') . '-4 border-blue-600 shadow-sm' : 'text-gray-500 hover:text-blue-600 hover:bg-gray-50 group' }}">
                        <i data-lucide="graduation-cap" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        <span class="text-sm tracking-tight">{{__('messages.students')}}</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="p-6 border-t border-gray-50">
                    <form action="{{route("logout")}}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-red-50 text-gray-500 hover:text-red-600 rounded-2xl border border-gray-50 hover:border-red-100 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 bg-white rounded-xl flex items-center justify-center shadow-sm group-hover:bg-red-100 transition-colors">
                                    <i data-lucide="log-out"
                                        class="w-4 h-4 transition-transform group-hover:{{ __('messages.page_direction') == 'rtl' ? 'translate-x-1' : '-translate-x-1' }}"></i>
                                </div>
                                <span
                                    class="text-xs font-black uppercase tracking-widest">{{__('messages.logout')}}</span>
                            </div>
                            <i data-lucide="chevron-{{ __('messages.page_direction') == 'rtl' ? 'left' : 'right' }}"
                                class="w-3 h-3 opacity-30 group-hover:opacity-100 transition-opacity"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header
                class="h-24 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <button class="md:hidden text-gray-400 p-2 hover:bg-gray-50 rounded-lg transition-colors"
                        onclick="toggleSidebar()">
                        <i data-lucide="menu" class="w-7 h-7"></i>
                    </button>

                    <div class="flex flex-col">
                        <div
                            class="flex items-center gap-3 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em] mb-1">
                            @yield('breadcrumb_prefix', 'Platform')
                            <div class="w-1 h-1 bg-gray-200 rounded-full"></div>
                            <span class="text-blue-500">@yield('breadcrumb_current', 'Admin')</span>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-none">@yield('page_title')
                        </h2>
                    </div>
                </div>

                <div class="flex items-center gap-4 py-2 px-3 bg-gray-50/50 rounded-2xl border border-gray-50">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-blue-100">
                        @auth {{ substr(auth()->user()->name, 0, 1) }} @endauth
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-black text-gray-900 tracking-tight leading-none mb-1">@auth
                        {{ auth()->user()->name }} @endauth</p>
                        <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest">Administrator</p>
                    </div>
                </div>
            </header>

            <main class="p-10 md:p-14 max-w-7xl">
                @yield('content')

                <footer
                    class="mt-24 pt-10 border-t border-gray-100/50 flex flex-col sm:flex-row justify-between items-center gap-4 opacity-50">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">© {{ date('Y') }} Smart
                        Education System</p>
                    <div class="flex items-center gap-8 text-[9px] font-black text-gray-400 uppercase tracking-widest">
                        <span class="cursor-help hover:text-blue-500 transition-colors">Documentation</span>
                        <span class="cursor-help hover:text-blue-500 transition-colors">Support</span>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <div id="sidebar-overlay"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-md z-40 hidden md:hidden transition-all duration-500"
        onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('sidebar-visible');
            overlay.classList.toggle('hidden');
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (sidebar) sidebar.classList.remove('sidebar-visible');
                if (overlay) overlay.classList.add('hidden');
            }
        });

        lucide.createIcons();
    </script>
    @stack('scripts')
    @livewireScripts
</body>

</html>
