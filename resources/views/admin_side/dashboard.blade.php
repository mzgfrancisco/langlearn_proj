@extends('layouts.admin')

@section('main-content')
<div class="ml-60 p-8 bg-slate-50 min-h-screen text-slate-800">
    <h1 class="text-3xl font-extrabold mb-6">Welcome, Admin</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-lg text-center p-6 transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]">
            <i class="fa fa-users text-white bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl mb-3 text-3xl shadow"></i>
            <h6 class="text-slate-500 font-semibold mb-1">Total Users</h6>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $userCount ?? 0 }}</h3>
        </div>

        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-lg text-center p-6 transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]">
            <i class="fa fa-book text-white bg-gradient-to-r from-sky-400 to-cyan-400 p-3 rounded-xl mb-3 text-3xl shadow"></i>
            <h6 class="text-slate-500 font-semibold mb-1">Total Categories</h6>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $categoryCount ?? 0 }}</h3>
        </div>

        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-lg text-center p-6 transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]">
            <i class="fa fa-chart-line text-white bg-gradient-to-r from-green-400 to-emerald-500 p-3 rounded-xl mb-3 text-3xl shadow"></i>
            <h6 class="text-slate-500 font-semibold mb-1">User Growth Rate</h6>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $avgScore ?? 0 }}%</h3>
        </div>

        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-lg text-center p-6 transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]">
            <i class="fa fa-check-circle text-white bg-gradient-to-r from-amber-400 to-yellow-300 p-3 rounded-xl mb-3 text-3xl shadow"></i>
            <h6 class="text-slate-500 font-semibold mb-1">Progress Reports</h6>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $completionRate ?? 0 }}%</h3>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-md p-6 transition-all hover:shadow-xl">
            <h5 class="font-bold text-slate-700 mb-3">Category Average Score</h5>
            <canvas id="avgScoreChart" height="150"></canvas>
        </div>

        <div class="bg-white/90 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-md p-6 transition-all hover:shadow-xl">
            <h5 class="font-bold text-slate-700 mb-3">Category Completion Rate</h5>
            <canvas id="completionRateChart" height="150"></canvas>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white/95 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-md p-6">
        <h5 class="font-bold text-slate-700 mb-4">Quiz Reports</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-slate-700">
                <thead class="bg-slate-200 text-slate-800 font-bold uppercase text-sm">
                    <tr>
                        <th class="py-3 px-4 text-left">User</th>
                        <th class="py-3 px-4 text-left">Category</th>
                        <th class="py-3 px-4 text-left">Quizzes Taken</th>
                        <th class="py-3 px-4 text-left">Average Score</th>
                        <th class="py-3 px-4 text-left">Completion Rate</th>
                        <th class="py-3 px-4 text-left">Retakes</th>
                        <th class="py-3 px-4 text-left">Last Activity</th>
                    </tr>
                </thead>
                <tbody id="dashboard_report" class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-100 transition">
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                        <td class="py-2 px-4">—</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const avgScoreCtx = document.getElementById('avgScoreChart');
new Chart(avgScoreCtx, {
    type: 'bar',
    data: {
        labels: @json(array_keys($avgScoreData ?? [])),
        datasets: [{
            label: 'Average Score (%)',
            data: @json(array_values($avgScoreData ?? [])),
            backgroundColor: '#3b82f6',
            borderRadius: 8
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + "%" } } },
        plugins: { legend: { display: false } }
    }
});

const completionRateCtx = document.getElementById('completionRateChart');
new Chart(completionRateCtx, {
    type: 'bar',
    data: {
        labels: @json(array_keys($completionRateData ?? [])),
        datasets: [{
            label: 'Completion Rate (%)',
            data: @json(array_values($completionRateData ?? [])),
            backgroundColor: '#16a34a',
            borderRadius: 8
        }]
    },
    options: {
        scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + "%" } } },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
