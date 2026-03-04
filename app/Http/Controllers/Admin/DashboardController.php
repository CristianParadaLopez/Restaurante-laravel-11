<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $foodsCount = Food::count();
        $ordersCount = Order::count();
        $reservationsCount = Reservation::count();
        $tablesCount = Table::count();

        return view('admin.dashboard', compact(
            'usersCount',
            'foodsCount',
            'ordersCount',
            'reservationsCount',
            'tablesCount'
        ));
    }
}
