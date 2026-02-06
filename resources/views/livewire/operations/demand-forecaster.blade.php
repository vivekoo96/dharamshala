<div class="p-6">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ trans_db('ai_demand_forecasting') }} 🧠</h1>
        <p class="text-sm text-gray-600 mt-1">{{ trans_db('forecasting_subtitle') }}</p>
    </div>

    {{-- Controls & Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Controls --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <label class="block text-sm font-bold text-gray-700 mb-2">{{ trans_db('forecast_horizon') }}</label>
            <select wire:model.live="forecastDays"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <option value="7">{{ trans_db('next_7_days') }}</option>
                <option value="14">{{ trans_db('next_14_days') }}</option>
                <option value="30">{{ trans_db('next_30_days') }}</option>
                <option value="60">{{ trans_db('next_60_days') }}</option>
                <option value="90">{{ trans_db('next_90_days') }}</option>
            </select>
        </div>

        {{-- Projected Revenue --}}
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 rounded-2xl shadow-lg text-white">
            <div class="flex items-center justify-between mb-2">
                <span class="text-blue-100 font-medium text-sm">{{ trans_db('projected_revenue') }}</span>
                <svg class="w-5 h-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="text-3xl font-bold">₹{{ number_format($projectedRevenue) }}</div>
            <div class="mt-2 text-xs text-blue-100 opacity-80">{{ trans_db('estimated_rates_hint') }}</div>
        </div>

        {{-- Occupancy Insight --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <label class="block text-sm font-bold text-gray-700 mb-2">{{ trans_db('avg_occupancy') }}</label>
            <div class="flex items-end items-baseline">
                @php
                    $avgOccupancy = collect($predictions)->avg('occupancy_rate');
                @endphp
                <span
                    class="text-3xl font-bold {{ $avgOccupancy > 70 ? 'text-green-600' : ($avgOccupancy > 40 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ number_format($avgOccupancy, 1) }}%
                </span>
                <span class="ml-2 text-sm text-gray-500">{{ trans_db('expected') }}</span>
            </div>
            <div class="mt-3 w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                    style="width: {{ $avgOccupancy }}%"></div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8" wire:ignore>
        <h3 class="text-lg font-bold text-gray-800 mb-4">{{ trans_db('occupancy_trend') }}</h3>
        <canvas id="forecastChart" height="100"></canvas>
    </div>

    {{-- Daily Breakdown --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">{{ trans_db('daily_forecast_breakdown') }}</h3>
            <button wire:click="exportCSV"
                class="text-xs text-blue-600 hover:text-blue-800 font-bold flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                {{ trans_db('export_as_csv') }}
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ trans_db('date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ trans_db('day') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ trans_db('projected_occupancy') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            {{ trans_db('status') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($predictions as $day)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($day['date'])->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $day['day'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-bold mr-2">{{ $day['occupancy_rate'] }}%</span>
                                    <div class="w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-blue-500 h-1.5 rounded-full"
                                            style="width: {{ $day['occupancy_rate'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($day['occupancy_rate'] > 80)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ trans_db('high_demand') }}</span>
                                @elseif($day['occupancy_rate'] > 50)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ trans_db('moderate') }}</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ trans_db('low') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('forecastChart');
            let chart;

            const initChart = (data) => {
                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => {
                            const date = new Date(d.date);
                            return `${date.getDate()} ${date.toLocaleString('default', { month: 'short' })}`;
                        }),
                        datasets: [{
                            label: 'Predicted Occupancy (%)',
                            data: data.map(d => d.occupancy_rate),
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#3b82f6',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (context) => ` Occupancy: ${context.raw}%`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                grid: { color: '#f3f4f6' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            };

            // Initialize
            initChart(@json($predictions));

            // Update on refresh
            Livewire.on('forecast-updated', (data) => {
                initChart(data[0]);
            });

            // Re-render when property changes
            Livewire.hook('morph.updated', ({ component, el }) => {
                // Component updated logic if needed
            });
        });

        // Listen for livewire updates to refresh chart
        document.addEventListener('livewire:navigating', () => {
            // Cleanup if needed
        });
    </script>
</div>