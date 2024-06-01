<?php

use App\Models\Due;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('due_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Due::class)->constrained()->cascadeOnDelete();
            $table->double('take_amount');
            $table->double('return_amount');
            $table->timestamp('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_details');
    }
};
