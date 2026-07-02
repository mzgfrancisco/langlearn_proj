<aside class="fixed top-0 left-0 w-60 min-h-screen bg-gradient-to-br from-slate-800 via-slate-900 to-sky-500 shadow-2xl border-r border-slate-700  text-slate-100 flex flex-col">
    <!-- Header -->
    <h4 class="text-lg font-extrabold px-6 py-5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white  tracking-wide shadow-md">
        LangLearn Admin
    </h4>

    <!-- Navigation -->
    <nav class="flex-1 px-2 py-4 space-y-1 space-x-3">
        <!-- Dashboard -->
        <a href="{{ route('admin_dashboard') }}"
            class="flex items-center px-4 py-2 rounded-lg text-slate-200 font-medium text-base transition-all duration-300
            {{ request()->routeIs('admin_dashboard')
                ? 'bg-gradient-to-r from-sky-400 to-cyan-400 text-white shadow-lg translate-x-2 '
                : 'hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white hover:translate-x-2' }}">
            <i class="fa fa-home text-lg mr-3"></i>
            Dashboard
        </a>

        <!-- Categories -->
        <a href="{{ route('categories.index') }}"
            class="flex items-center px-4 py-2 rounded-lg text-slate-200 font-medium text-base transition-all duration-300
            {{ request()->routeIs('categories.index')
                ? 'bg-gradient-to-r from-sky-400 to-cyan-400 text-white shadow-lg translate-x-2'
                : 'hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white hover:translate-x-2' }}">
            <i class="fa fa-book text-lg mr-3"></i>
            Categories
        </a>

        <!-- Reports -->
        <a href="{{ route('admin_reports') }}"
            class="flex items-center px-4 py-2 rounded-lg text-slate-200 font-medium text-base transition-all duration-300
            {{ request()->routeIs('admin_reports')
                ? 'bg-gradient-to-r from-sky-400 to-cyan-400 text-white shadow-lg translate-x-2'
                : 'hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white hover:translate-x-2' }}">
            <i class="fa fa-chart-bar text-lg mr-3"></i>
            Quiz Reports
        </a>

        <!-- Users -->
        <a href="{{ route('manage_users') }}"
            class="flex items-center px-4 py-2 rounded-lg text-slate-200 font-medium text-base transition-all duration-300
            {{ request()->routeIs('manage_users')
                ? 'bg-gradient-to-r from-sky-400 to-cyan-400 text-white shadow-lg translate-x-2'
                : 'hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white hover:translate-x-2' }}">
            <i class="fa fa-users text-lg mr-3"></i>
            Users
        </a>


        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-[21rem] mb-4 px-2 ">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-2 py-2 rounded-lg text-left text-slate-200 font-medium transition-all duration-300 hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-600 hover:text-white hover:translate-x-2">
                <i class="fa fa-sign-out-alt text-lg mr-3"></i>
                Log Out
            </button>
        </form>
    </nav>
</aside>
