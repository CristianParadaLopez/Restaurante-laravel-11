<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tablesCount = Table::count();
        $reservedCount = Table::where('status', 'reservada')->count();
        $availableCount = Table::where('status', 'disponible')->count();
        $reservationsToday = Reservation::whereDate('date', now()->toDateString())->count();

        return view('mesero.meserohome', compact(
            'tablesCount',
            'reservedCount',
            'availableCount',
            'reservationsToday'
        ));
    }
}
