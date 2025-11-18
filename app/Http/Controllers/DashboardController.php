<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $balance = $user->balance;
        
        $cards = $user->cards()
            ->with('transactions')
            ->latest()
            ->get();
        
        $recentTransactions = $user->transactions()
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.modern', compact('user', 'balance', 'cards', 'recentTransactions'));
    }
}
