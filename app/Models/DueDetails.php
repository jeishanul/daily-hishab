<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'due_date',
        'take_amount',
        'return_amount'

    ];

    public function due()
    {
        return $this->belongsTo(Due::class);
    }
}
