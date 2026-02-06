<?php

namespace App\Livewire\Operations;

use App\Services\ForecastingService;
use Carbon\Carbon;
use Livewire\Component;

class DemandForecaster extends Component
{
    public $forecastDays = 30;
    public $predictions = [];
    public $projectedRevenue = 0;
    public $loading = true;

    public function mount(ForecastingService $forecaster)
    {
        $this->generateForecast($forecaster);
    }

    public function generateForecast(ForecastingService $forecaster)
    {
        $this->loading = true;

        // Slight delay to simulate complex calculation (for UI feedback)
        // In real AI apps, this might be an API call

        $this->predictions = $forecaster->predictOccupancy($this->forecastDays);
        $this->projectedRevenue = $forecaster->calculateProjectedRevenue($this->predictions);

        $this->loading = false;
    }

    public function updatedForecastDays()
    {
        $this->generateForecast(app(ForecastingService::class));
        $this->dispatch('forecast-updated', $this->predictions);
    }

    public function exportCSV()
    {
        $filename = "demand-forecast-" . now()->format('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Date', 'Day', 'Occupancy Rate (%)', 'Status']);

        foreach ($this->predictions as $day) {
            $status = $day['occupancy_rate'] > 80 ? 'High' : ($day['occupancy_rate'] > 50 ? 'Moderate' : 'Low');
            fputcsv($handle, [
                $day['date'],
                $day['day'],
                $day['occupancy_rate'],
                $status
            ]);
        }

        return response()->streamDownload(function () use ($handle) {
            fclose($handle);
        }, $filename);
    }

    public function render()
    {
        return view('livewire.operations.demand-forecaster');
    }
}
