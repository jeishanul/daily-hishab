<?php

use App\Models\Product;
use App\Models\SaleReturn;
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
        Schema::create('sale_return_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SaleReturn::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->integer('qty');
            $table->double('discount', 25, 2)->nullable();
            $table->double('price', 25, 2)->nullable();
            $table->double('tax_rate', 25, 2)->nullable();
            $table->double('tax', 25, 2)->nullable();
            $table->double('total', 25, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_return_products');
    }
};
