<?php

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sale::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->integer('qty');
            $table->double('price', 25, 2);
            $table->double('discount', 25, 2)->nullable();
            $table->double('tax_rate', 25, 2)->nullable();
            $table->double('tax', 25, 2)->nullable();
            $table->double('total', 25, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sales');
    }
}