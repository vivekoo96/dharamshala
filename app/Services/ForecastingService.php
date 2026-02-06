<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForecastingService
{
    /**
     * Predict occupancy for the next X days.
     * Uses a simple weighted average of:
     * 1. Same period last year (50% weight) - Seasonality
     * 2. Last month's average (30% weight) - Recent trend
     * 3. Same period last month (20% weight) - Immediate trend
     *
     * @param int $days
     * @return array
     */
    public function predictOccupancy(int $days = 30): array
    {
        $startDate = Carbon::today();
        $predictions = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);

            // 1. Historical Seasonality (Same day last year)
            $lastYearDate = $date->copy()->subYear();
            $lastYearOccupancy = $this->getOccupancyRateForDate($lastYearDate);

            // 2. Recent Trend (Average of last 30 days)
            $lastMonthAvg = $this->getAverageOccupancy(30);

            // 3. Immediate Trend (Same day last month)
            $lastMonthDate = $date->copy()->subMonth();
            $lastMonthOccupancy = $this->getOccupancyRateForDate($lastMonthDate);

            // Weighted Prediction
            // If no data for last year, rely more on recent trends
            if ($lastYearOccupancy === 0) {
                $predictedRate = ($lastMonthAvg * 0.6) + ($lastMonthOccupancy * 0.4);
            } else {
                $predictedRate = ($lastYearOccupancy * 0.5) + ($lastMonthAvg * 0.3) + ($lastMonthOccupancy * 0.2);
            }

            // Cap at 100% and Floor at 0%
            $predictedRate = max(0, min(100, $predictedRate));

            // Add some randomness for "simulation" if database is empty (for demo purposes)
            // REMOVE THIS IN PRODUCTION if real data exists
            if ($predictedRate == 0 && Booking::count() < 10) {
                $predictedRate = rand(40, 85);
            }

            $predictions[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'occupancy_rate' => round($predictedRate, 1),
                'is_weekend' => $date->isWeekend(),
            ];
        }

        return $predictions;
    }

    /**
     * Get actual occupancy rate for a specific date.
     */
    private function getOccupancyRateForDate(Carbon $date): float
    {
        $totalRooms = DB::table('rooms')->count();

        if ($totalRooms === 0)
            return 0;

        $bookedRooms = DB::table('bookings')
            ->whereDate('check_in', '<=', $date)
            ->whereDate('check_out', '>', $date)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        return ($bookedRooms / $totalRooms) * 100;
    }

    /**
     * Get average occupancy rate over the last X days.
     */
    private function getAverageOccupancy(int $days): float
    {
        $totalRooms = DB::table('rooms')->count();
        if ($totalRooms === 0)
            return 0;

        $totalPercentage = 0;
        $validDays = 0;

        for ($i = 1; $i <= $days; $i++) {
            $date = Carbon::today()->subDays($i);
            $rate = $this->getOccupancyRateForDate($date);
            $totalPercentage += $rate;
            $validDays++;
        }

        return $validDays > 0 ? $totalPercentage / $validDays : 0;
    }

    /**
     * Calculate projected revenue based on predicted occupancy.
     * Assumes average room rate.
     */
    public function calculateProjectedRevenue(array $predictions): float
    {
        $averageRoomRate = DB::table('room_categories')->avg('base_tariff') ?? 800; // Default fallback
        $totalRooms = DB::table('rooms')->count();

        $totalRevenue = 0;

        foreach ($predictions as $day) {
            $occupiedRooms = ceil(($day['occupancy_rate'] / 100) * $totalRooms);
            $totalRevenue += $occupiedRooms * $averageRoomRate;
        }

        return $totalRevenue;
    }
}
