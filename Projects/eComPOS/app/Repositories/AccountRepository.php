<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountRepository extends Repository
{
    public static function model()
    {
        return Account::class;
    }
    public static function storeByRequest(Request $request)
    {
        $account = self::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'account_no' => $request->account_no,
            'note' => $request->note,
            'balance' => $request->balance,
            'is_default' => $request->is_default,
        ]);

        return $account;
    }

    public static function updateByRequest(Request $request, Account $account)
    {
        $updateBlance = $account->balance + $request->balance;
        $update = self::update($account, [
            'name' => $request->name,
            'account_no' => $request->account_no,
            'note' => $request->note,
            'balance' => $updateBlance,
            'is_default' => $request->is_default,
        ]);

        return $update;
    }

    public static function addBalance(Request $request, Account $account)
    {
        $updateBlance = $account->balance + $request->balance;
        $update = self::update($account, [
            'balance' => $updateBlance,
        ]);
        return $update;
    }

    public static function balanceUpdate($totalBalance, Account $account)
    {
        return self::update($account, [
            'balance' => $totalBalance
        ]);
    }
}
