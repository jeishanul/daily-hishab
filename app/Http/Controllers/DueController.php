<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\DueDetails;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index()
    {
        $dues = auth()->user()->dues()->with('details')->get();
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

        $due = auth()->user()->dues()->where('name', $request->name)->firstOrCreate([
            'name' => $request->name
        ]);

        $due->details()->create([
            'due_date' => $request->due_date,
            'take_amount' => $request->take_amount,
            'return_amount' => 0

        ]);

        auth()->user()->wallet()->decrement('balance', $request->take_amount);

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
            'due_date' => 'required|date',
        ]);

        $dueDetails->update([
            'due_date' => $request->due_date,
            'take_amount' => $request->take_amount,
            'return_amount' => 0
        ]);

        auth()->user()->wallet()->decrement('balance', $request->take_amount);

        return redirect()->route('dues.index');
    }

    public function destroy(Due $due)
    {
        $due->delete();
        return redirect()->route('dues.index');
    }

    public function destroyDueDetails(DueDetails $dueDetails)
    {
        $dueDetails->delete();
        return redirect()->route('dues.index');
    }
}
