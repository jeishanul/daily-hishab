<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletRepository extends Repository
{
    public static function model()
    {
        return Wallet::class;
    }

    public static function credit(Wallet $wallet, $amount): bool
    {
        $balance = ($wallet->balance + $amount);
        $account = $wallet->account;
        
        if ($account) {
            AccountRepository::balanceUpdate($balance, $account);
        }
        $wallet->update([
            'balance' => $balance
        ]);
        return true;
    }

    public static function debit(Wallet $wallet, $amount)
    {
        if ($wallet->balance > $amount) {
            $balance = ($wallet->balance - $amount);
            $account = $wallet->account;

            if ($account) {
                AccountRepository::balanceUpdate($balance, $account);
            }
            $wallet->update([
                'balance' => $balance
            ]);
            return true;
        }
        return false;
    }

    public static function store(User $user): Wallet
    {
        return self::create([
            'user_id' => $user->id,
            'balance' => '0',
        ]);
    }
}
