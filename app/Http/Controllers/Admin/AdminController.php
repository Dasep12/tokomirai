<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Services;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {
        // ── Stat Cards ──────────────────────────────────────────────
        $totalUsers       = User::count();
        $totalProducts    = Product::count();
        $totalTransactions = Transactions::count();
        $totalServices    = Services::where('is_active', 1)->count();

        // ── User status breakdown ────────────────────────────────────
        $userStatus = User::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $userActive   = $userStatus['ACTIVE']   ?? 0;
        $userInactive = $userStatus['INACTIVE'] ?? 0;
        $userBlocked  = $userStatus['BLOCKED']  ?? 0;

        // ── Transaction status breakdown ─────────────────────────────
        $txStatus = Transactions::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $txPending  = $txStatus['PENDING']  ?? 0;
        $txProcess  = $txStatus['PROCESS']  ?? 0;
        $txShipping = $txStatus['SHIPPING'] ?? 0;
        $txDone     = $txStatus['DONE']     ?? 0;

        // ── Monthly transaction trend (12 bulan terakhir) ─────────────
        $monthlyTrend = Transactions::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            'status',
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('year', 'month', 'status')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Reshape for Chart.js: 6 bulan terakhir
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));
        $chartLabels = $months->map(fn($m) => $m->translatedFormat('M'))->values();

        $statuses = ['PENDING', 'PROCESS', 'SHIPPING', 'DONE'];
        $chartData = [];
        foreach ($statuses as $s) {
            $chartData[$s] = $months->map(function ($m) use ($monthlyTrend, $s) {
                return $monthlyTrend
                    ->where('month', $m->month)
                    ->where('year',  $m->year)
                    ->where('status', $s)
                    ->first()?->total ?? 0;
            })->values();
        }

        // ── Recent transactions ──────────────────────────────────────
        $recentTransactions = Transactions::latest()->take(5)->get();

        // ── Top products by sold ─────────────────────────────────────
        $topProducts = Product::orderByDesc('sold')->take(5)->get();

        // ── Services ────────────────────────────────────────────────
        $services = Services::where('is_active', 1)->take(8)->get();

        // ── Revenue total ────────────────────────────────────────────
        $totalRevenue = Transactions::where('status', 'DONE')->sum('grand_total');

        return view('admin.home.index', compact(
            'totalUsers',
            'totalProducts',
            'totalTransactions',
            'totalServices',
            'userActive',
            'userInactive',
            'userBlocked',
            'txPending',
            'txProcess',
            'txShipping',
            'txDone',
            'chartLabels',
            'chartData',
            'recentTransactions',
            'topProducts',
            'services',
            'totalRevenue'
        ));
    }
}
