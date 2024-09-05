<?php

namespace App\Repositories;

use App\Models\MoneyTransfer;
use Illuminate\Http\Request;

class MoneyTransferRepository extends Repository
{
    public static function model()
    {
        return MoneyTransfer::class;
    }
    
    public static function storeByRequest(Request $request)
    {
        $fromAccount = AccountRepository::find($request->from_account_id);
        $toAccount = AccountRepository::find($request->to_account_id);

        $debit = $fromAccount->balance - $request->amount;
        AccountRepository::balanceUpdate($debit, $fromAccount);
        TransactionRepository::debitByRequest('Bank', $request->amount, $fromAccount->id, 'moneytransfer');

        $credit = $toAccount->balance + $request->amount;
        AccountRepository::balanceUpdate($credit, $toAccount);
        TransactionRepository::creditByRequest('Bank', $request->amount, $toAccount->id, 'moneytransfer');

        $create = self::create([
            'reference_no' => 'mtr-' . date("Ymd") . '-' . date("his"),
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
        ]);
        return $create;
    }

    public static function updateByRequest(Request $request, MoneyTransfer $moneyTransfer)
    {
        $update = self::update($moneyTransfer, [
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
        ]);
        return $update;
    }
}
