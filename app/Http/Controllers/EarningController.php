<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use App\Models\EarningDetails;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function index()
    {
        $earnings = auth()->user()->earnings()->with('details')->orderBy('date','asc')->get();
        return view('earnings.index', compact('earnings'));
    }

    public function create()
    {
        return view('earnings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $user = auth()->user();

        $earning = $user->earnings()->whereDate('date', $request->date)->firstOrCreate(
            [
                'date' => $request->date,
            ]
        );

        $earning->details()->create([
            'description' => $request->description,
            'amount' => $request->amount
        ]);

        $user->wallet()->increment('balance', $request->amount);

        return redirect()->route('earnings.index');
    }

    public function show(Earning $earning)
    {
        $earning = $earning->with('details')->first();
        return view('earnings.show', compact('earning'));
    }

    public function edit(EarningDetails $earningDetails)
    {
        return view('earnings.edit', compact('earningDetails'));
    }

    public function update(Request $request, EarningDetails $earningDetails)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $wallet = auth()->user()->wallet;
        $wallet->decrement('balance', $earningDetails->amount);
        $wallet->increment('balance', $request->amount);

        $earningDetails->update([
            'description' => $request->description,
            'amount' => $request->amount
        ]);

        return redirect()->route('earnings.index');
    }

    public function destroy(Earning $earning)
    {
        auth()->user()->wallet->decrement('balance', $earning->details()->sum('amount'));
        $earning->delete();
        return redirect()->route('earnings.index');
    }

    public function destroyEarningDetailsDetails(EarningDetails $earningDetails)
    {
        auth()->user()->wallet->decrement('balance', $earningDetails->amount);
        $earningDetails->delete();
        return redirect()->route('earnings.index');
    }
}
