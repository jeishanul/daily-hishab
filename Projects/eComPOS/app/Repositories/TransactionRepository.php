<?php

namespace App\Repositories;

use App\Enums\TransectionType;
use App\Models\Transaction;

class TransactionRepository extends Repository
{
    public static function model()
    {
        return Transaction::class;
    }

    public static function getCurrntMonthCredit()
    {
        return self::query()->whereMonth('created_at', date('m'))->where('transection_type', TransectionType::CREDIT->value)->get();
    }

    public static function storeByRequestForBank($request, $accountOrUserId, bool $isCredit)
    {
        $wallet = WalletRepository::query()->where('user_id', $accountOrUserId)->orWhere('account_id', $accountOrUserId)->first();

        if ($isCredit) {
            $type = TransectionType::CREDIT->value;
            WalletRepository::credit($wallet, $request->amount);
        } else {
            $type = TransectionType::DEBIT->value;
            WalletRepository::debit($wallet, $request->amount);
        }

        return self::storeByRequestForCash($request, $type);
    }

    public static function storeByRequestForCash($request, $type)
    {

        $date = $request->date ? $request->date : now()->format('Y-m-d');
        return self::create([
            'user_id' => auth()->id(),
            'payment_method' => $request->payment_method,
            'transection_type' => $type,
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'account_id' => $request->account_id,
            'date' => $date,
        ]);
    }

    public static function creditByRequest($paymentMethod, $amount, $accountId, $purpose = null, $date = null)
    {
        $transctionDate = $date ??  now();

        return self::create([
            'user_id' => auth()->id(),
            'payment_method' => $paymentMethod,
            'transection_type' => TransectionType::CREDIT->value,
            'amount' => $amount,
            'account_id' => $accountId,
            'purpose' => $purpose,
            'date' => $transctionDate,
        ]);
    }

    public static function debitByRequest($paymentMethod, $amount, $accountId, $purpose = null, $date = null)
    {
        $transctionDate = $date ??  now();

        return self::create([
            'user_id' => auth()->id(),
            'payment_method' => $paymentMethod,
            'transection_type' => TransectionType::DEBIT->value,
            'amount' => $amount,
            'account_id' => $accountId,
            'purpose' => $purpose,
            'date' => $transctionDate,
        ]);
    }

    public static function filterByMonth($startDate, $endDate, $type)
    {
        return self::query()->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
            ->selectRaw('COALESCE(SUM(amount), 0) as total_amount')
            ->where('transection_type', $type)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
