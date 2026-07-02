@extends('layouts.admin')

@section('main-content')
<div class="flex min-h-screen bg-slate-50">
    <div class="flex-1 p-8 ml-60">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Quiz Reports</h2>

        <!-- Search -->
        <div class="relative max-w-sm mb-6">
            <input
                id="searchReports"
                type="text"
                placeholder="Search by username or category..."
                class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-2 text-slate-700 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none shadow-sm"
            >
            <i class="fa fa-search absolute left-3 top-2.5 text-slate-400"></i>
        </div>

        <!-- Table Container -->
        <div class="bg-white/90 rounded-2xl shadow-xl border border-slate-200 backdrop-blur-lg transition-all p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-xl shadow-sm text-center">
                    <thead class="bg-slate-100 text-slate-700 font-semibold">
                        <tr>
                            <th class="p-3">No.</th>
                            <th class="p-3">Username</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Quizzes Taken</th>
                            <th class="p-3">Average Score</th>
                            <th class="p-3">Completion Rate</th>
                            <th class="p-3">Retakes</th>
                            <th class="p-3">Last Activity</th>
                        </tr>
                    </thead>
                    <tbody id="reportTable" class="text-slate-700 text-sm">
                        <tr>
                            <td colspan="8" class="py-4 text-slate-400">Loading reports...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="flex justify-center mt-6 space-x-2">
                <button class="px-3 py-1 rounded-lg text-blue-600 font-semibold bg-slate-100 shadow-sm hover:bg-blue-500 hover:text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="px-3 py-1 rounded-lg text-blue-600 font-semibold bg-slate-100 shadow-sm hover:bg-blue-500 hover:text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
