<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Repositories\AccountRepository;
use App\Repositories\ExpenseCategoryRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WarehouseRepository;

class ExpenseController extends Controller
{
    public function index()
    {
        $request = request();
        $hasDate = false;
        $startDate = date('m/d/Y');
        $endDate = date('m/d/Y', strtotime('+8 days'));
        if ($request->start_date && $request->end_date) {
            $startMil = $request->start_date;
            $startSeconds = $startMil / 1000;
            $startDate = date("m/d/Y", $startSeconds);
            $endMil = $request->end_date;
            $endSeconds = $endMil / 1000;
            $endDate = date("m/d/Y", $endSeconds);
            $hasDate = true;
        }
        $expenses = ExpenseRepository::query()->when($hasDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->get();

        $warehouses =  WarehouseRepository::query()->orderByDesc('id')->get();
        $exCategories = ExpenseCategoryRepository::query()->orderByDesc('id')->get();
        $accounts = request()->user()->accounts()->where('is_default', 1)->orderByDesc('id')->get();
        return view('expense.index', compact('accounts', 'expenses', 'warehouses', 'exCategories', 'startDate', 'endDate'));
    }

    public function store(ExpenseRequest $request)
    {

        $account = AccountRepository::query()->where('id', $request->account_id)->first();
        if ($request->amount > $account->balance) {
            return back()->with('error', 'Your account does not have enough money!');
        }
        TransactionRepository::debitByRequest('Bank', $request->amount, $request->account_id, 'Expense');
        ExpenseRepository::storeByRequest($request);
        $account->update(['balance' => $account->balance - $request->amount]);
        return back()->with('success', 'Data is inserted successfully');
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        ExpenseRepository::updateByRequest($request, $expense);
        return back()->with('success', 'Data is updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Data is deleted successfully');
    }
}
