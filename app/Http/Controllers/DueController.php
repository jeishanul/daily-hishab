<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\DueDetails;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index()
    {
        $dues = auth()->user()->dues()->with('details')->orderByDesc('id')->get();
        return view('dues.index', compact('dues'));
    }

    public function create()
    {
        return view('dues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'take_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $user = auth()->user();

        $due = $user->dues()->where('name', $request->name)->firstOrCreate([
            'name' => $request->name
        ]);

        $due->details()->create([
            'due_date' => $request->due_date,
            'take_amount' => $request->take_amount,
            'return_amount' => 0

        ]);

        $user->wallet->decrement('balance', $request->take_amount);

        return redirect()->route('dues.index');
    }

    public function show(Due $due)
    {
        $due = $due->with('details')->first();
        return view('dues.show', compact('due'));
    }

    public function edit(DueDetails $dueDetails)
    {
        return view('dues.edit', compact('dueDetails'));
    }

    public function update(Request $request, DueDetails $dueDetails)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'take_amount' => 'required|numeric',
            'return_amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $wallet = auth()->user()->wallet;
        $wallet->increment('balance', $dueDetails->take_amount - $request->take_amount);
        $wallet->decrement('balance', $dueDetails->return_amount - $request->return_amount);

        $dueDetails->update([
            'due_date' => $request->due_date,
            'take_amount' => $request->take_amount,
            'return_amount' => $request->return_amount
        ]);

        return redirect()->route('dues.index');
    }

    public function destroy(Due $due)
    {
        $wallet = auth()->user()->wallet;
        $wallet->increment('balance', $due->details()->sum('take_amount'));
        $wallet->decrement('balance', $due->details()->sum('return_amount'));

        $due->delete();
        return redirect()->route('dues.index');
    }

    public function destroyDueDetails(DueDetails $dueDetails)
    {
        $wallet = auth()->user()->wallet;
        $wallet->increment('balance', $dueDetails->take_amount);
        $wallet->decrement('balance', $dueDetails->return_amount);

        $dueDetails->delete();
        return redirect()->route('dues.index');
    }
}
