<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\V1\Payment;
use App\Models\V1\Visitor;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    use HttpResponses;

    public function getRevenueChart(Request $request)
    {
        $year = $request->query('year', date('Y'));

        $salesData = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdfData = [
            ['month' => 9, 'year' => 2023, 'salesRevenue' => 700000, 'mySpurrFee' => 105000],
            ['month' => 10, 'year' => 2023, 'salesRevenue' => 397000, 'mySpurrFee' => 59550],
            ['month' => 1, 'year' => 2024, 'salesRevenue' => 3270000, 'mySpurrFee' => 490500],
            ['month' => 2, 'year' => 2024, 'salesRevenue' => 2250000, 'mySpurrFee' => 337500],
            ['month' => 3, 'year' => 2024, 'salesRevenue' => 1000000, 'mySpurrFee' => 150000],
            ['month' => 4, 'year' => 2024, 'salesRevenue' => 300000, 'mySpurrFee' => 45000],
            ['month' => 5, 'year' => 2024, 'salesRevenue' => 300000, 'mySpurrFee' => 45000],
            ['month' => 7, 'year' => 2024, 'salesRevenue' => 2100000, 'mySpurrFee' => 315000],
            ['month' => 8, 'year' => 2024, 'salesRevenue' => 600000, 'mySpurrFee' => 90000],
            ['month' => 9, 'year' => 2024, 'salesRevenue' => 400000, 'mySpurrFee' => 60000],
            ['month' => 10, 'year' => 2024, 'salesRevenue' => 2750000, 'mySpurrFee' => 412500],
            ['month' => 11, 'year' => 2024, 'salesRevenue' => 300000, 'mySpurrFee' => 45000],
            ['month' => 1, 'year' => 2025, 'salesRevenue' => 350000, 'mySpurrFee' => 52500],
        ];

        $labels = [];
        $salesRevenue = [];
        $mySpurrFee = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthData = $salesData->firstWhere('month', $i);
            $revenue = $monthData ? $monthData->total : 0;
            $pdfFee = $revenue * 0.15;

            foreach ($pdfData as $pdf) {
                if ($pdf['month'] === $i && $pdf['year'] === (int)$year) {
                    $revenue += $pdf['salesRevenue'];
                    $pdfFee = $pdf['mySpurrFee'];
                    break;
                }
            }

            $salesRevenue[] = $revenue;
            $mySpurrFee[] = $pdfFee;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Sales Revenue',
                    'data' => $salesRevenue
                ],
                [
                    'label' => 'MySpurr Fee',
                    'data' => $mySpurrFee
                ]
            ]
        ];

        return $this->success($chartData, "Revenue data");
    }

    public function getVisitors(Request $request)
    {
        $year = $request->query('year', date('Y'));

        $monthlyVisitors = Visitor::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $counts[] = $monthlyVisitors->where('month', $i)->first()->count ?? 0;
        }

        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => $counts
                ]
            ]
        ];

        return $this->success($data, "Visitors by month");
    }
}
