<aside 
    :class="sidebarOpen ? 'w-72' : 'w-24'"
    class="relative z-30 flex flex-col flex-shrink-0 h-full transition-all duration-300 ease-in-out bg-white/5 backdrop-blur-xl border-r border-white/10 shadow-2xl"
>
    <div class="flex items-center justify-between flex-shrink-0 px-6 py-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden whitespace-nowrap hover:opacity-80 transition-opacity" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-300 tracking-wider">SQS APP</span>
        </a>
        
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition-colors focus:outline-none">
            <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
            <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-4 mt-8 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <div class="{{ request()->routeIs('dashboard') ? 'text-white' : 'group-hover:text-indigo-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <span class="font-medium whitespace-nowrap" x-show="sidebarOpen">Dashboard</span>
            <div x-show="!sidebarOpen" class="absolute left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 pointer-events-none">Dashboard</div>
        </a>

        <a href="{{ route('quizzes.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('quizzes.*') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <div class="{{ request()->routeIs('quizzes.*') ? 'text-white' : 'group-hover:text-indigo-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="font-medium whitespace-nowrap" x-show="sidebarOpen">Kuis Saya</span>
        </a>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 shadow-lg shadow-indigo-500/30 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
            <div class="{{ request()->routeIs('profile.edit') ? 'text-white' : 'group-hover:text-indigo-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="font-medium whitespace-nowrap" x-show="sidebarOpen">Profil</span>
        </a>
    </nav>

    <div class="p-4 mt-auto border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-4 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200 group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="font-medium whitespace-nowrap" x-show="sidebarOpen">Log Out</span>
            </button>
        </form>
    </div>
</aside>