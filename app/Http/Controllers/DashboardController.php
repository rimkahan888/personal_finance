<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get transaction summaries
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
        $totalExpenses = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpenses;

        // Get recent transactions
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get monthly summary for current month (SQLite compatible)
        $currentMonth = now()->format('Y-m');
        $monthlyIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereRaw('strftime("%Y-%m", transaction_date) = ?', [$currentMonth])
            ->sum('amount');

        $monthlyExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereRaw('strftime("%Y-%m", transaction_date) = ?', [$currentMonth])
            ->sum('amount');

        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'balance',
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpenses'
        ));
    }
}
