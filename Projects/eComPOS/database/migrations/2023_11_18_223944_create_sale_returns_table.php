<?php

use App\Models\User;
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
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('reference_no');
            $table->integer('total_products');
            $table->integer('total_qty');
            $table->double('total_discount', 25, 2);
            $table->double('total_tax', 25, 2);
            $table->double('total_price', 25, 2);
            $table->double('grand_total', 25, 2);
            $table->double('order_tax', 25, 2)->nullable();
            $table->double('order_tax_rate', 25, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_returns');
    }
};
