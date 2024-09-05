<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Repositories\AccountRepository;

class AccountsController extends Controller
{
    public function index()
    {

        $accounts = request()->user()->accounts()->orderByDesc('id')->get();
        return view('account.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_no' => 'required|numeric|unique:accounts,account_no',
            'name' => 'required|string',
            'balance' => 'required|numeric',
            'is_default' => 'required|boolean',
        ]);

        $request->user()->accounts()->where('is_default', 1)->update(['is_default' => 0]);

        $account = AccountRepository::storeByRequest($request);

        if ($request->is_default) {
            $request->user()->wallet()->update([
                'balance' => $account->balance,
                'account_id' => $account->id
            ]);
        }

        return back()->with('success', 'Account is created successfully');
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'account_no' => 'required|numeric',
            'name' => 'required|string|max:255',
            'is_default' => 'required|boolean',
        ]);

        $request->user()->accounts()->where('is_default', 1)->update(['is_default' => 0]);

        AccountRepository::updateByRequest($request, $account);

        if ($request->is_default) {
            $request->user()->wallet()->update([
                'balance' => $account->balance,
                'account_id' => $account->id
            ]);
        }

        return back()->with('success', 'Account is updated successfully');
    }

    public function updateBalance(Request $request, Account $account)
    {
        $request->validate([
            'balance' => 'required|numeric',
        ]);

        AccountRepository::addBalance($request, $account);

        $request->user()->wallet()->update([
            'balance' => $account->balance,
            'account_id' => $account->id
        ]);
        return back()->with('success', 'Balance added successfully');
    }

    public function balanceSheet()
    {
        $accounts = request()->user()->accounts()->orderByDesc('id')->get();
        return view('account.balance_sheet', compact('accounts'));
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return back()->with('success', 'Account is deleted successfully');
    }
}
