<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'amount',
        'description'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
