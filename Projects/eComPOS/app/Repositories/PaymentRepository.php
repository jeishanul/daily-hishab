<?php

namespace App\Repositories;

use App\Enums\TransectionType;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentRepository extends Repository
{
    public static function model()
    {
        return Payment::class;
    }
    public static function storeByRequest(Request $request, $purchaseId)
    {
        $account = null;
        if ($request->payment_method == 'Bank') {
            $account = $request->account_id;
        }

        $amount = $request->paid_amount ? $request->paid_amount : 0;

        $storeByRequest = self::create([
            'reference' => 'pp-' . date("Ymd") . '-' . date("his"),
            'purchase_id' => $purchaseId,
            'account_id' =>  $account,
            'user_id' => auth()->id(),
            'payment_reference' => 'ppr-' . date("Ymd") . '-' . date("his"),
            'amount' => $amount,
            'payment_method' => $request->payment_method,
            'payment_note' => $request->payment_note,
        ]);
        return $storeByRequest;
    }

    public static function addPayment(Request $request, $account)
    {
        $payment = self::create([
            'reference' => 'pp-' . date("Ymd") . '-' . date("his"),
            'purchase_id' => $request->purchase_id,
            'account_id' =>  $account?->id,
            'user_id' => auth()->id(),
            'reference' => 'ppr-' . date("Ymd") . '-' . date("his"),
            'amount' => $request->paid_amount,
            'payment_method' => $request->payment_method,
            'note' => $request->payment_note,
        ]);

        return $payment;
    }
}
