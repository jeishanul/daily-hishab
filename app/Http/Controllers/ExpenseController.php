<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseDetails;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = auth()->user()->expenses()->with('details')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense = auth()->user()->expenses()->whereDate('date', $request->date)->firstOrCreate(
            [
                'date' => $request->date,
            ]
        );

        $expense->details()->create([
            'description' => $request->description,
            'amount' => $request->amount
        ]);

        auth()->user()->wallet()->decrement('balance', $request->amount);

        return redirect()->route('expenses.index');
    }

    public function show(Expense $expense)
    {
        $expense = $expense->with('details')->first();
        return view('expenses.show', compact('expense'));
    }

    public function edit(ExpenseDetails $expenseDetails)
    {
        return view('expenses.edit', compact('expenseDetails'));
    }

    public function update(Request $request, ExpenseDetails $expenseDetails)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $expenseDetails->update([
            'description' => $request->description,
            'amount' => $request->amount
        ]);

        return redirect()->route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index');
    }

    public function destroyExpenseDetails(ExpenseDetails $expenseDetails)
    {
        $expenseDetails->delete();
        return redirect()->route('expenses.index');
    }
}
