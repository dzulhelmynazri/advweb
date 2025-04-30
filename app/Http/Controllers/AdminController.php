<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCars = Car::count();
        $activeBookings = Booking::whereIn('status', ['pending', 'approved'])->count();
        $totalBranches = Branch::count();
        $totalUsers = User::where('role', 'customer')->count();
        $recentBookings = Booking::with(['user', 'car'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCars',
            'activeBookings',
            'totalBranches',
            'totalUsers',
            'recentBookings'
        ));
    }
}
