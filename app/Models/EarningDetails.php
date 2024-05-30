<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'description'
    ];

    public function earning()
    {
        return $this->belongsTo(Earning::class);
    }
}
