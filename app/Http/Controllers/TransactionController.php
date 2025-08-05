<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::forUser(Auth::id())
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);
            
        $totalIncome = Transaction::forUser(Auth::id())
            ->income()
            ->sum('amount');
            
        $totalExpenses = Transaction::forUser(Auth::id())
            ->expense()
            ->sum('amount');
            
        $balance = $totalIncome - $totalExpenses;
        
        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpenses', 'balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create', Transaction::class)) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Transaction::create($validated);
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
            if (!auth()->user()->cannot('view', $transaction)) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        if (!Auth::user()->can('update', $transaction)) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date',
        ]);
        
        $transaction->update($validated);
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
        $transaction->delete();
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully!');
    }
}
