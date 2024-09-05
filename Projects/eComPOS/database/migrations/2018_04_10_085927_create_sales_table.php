<?php

use App\Models\Customer;
use App\Models\Media;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->foreignIdFor(User::class)->constrained()->nullable()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'customer_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Warehouse::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('total_product');
            $table->double('total_qty');
            $table->double('total_discount', 25, 2);
            $table->double('total_tax', 25, 2);
            $table->double('total_price', 25, 2);
            $table->double('grand_total', 25, 2);
            $table->double('order_tax_rate')->nullable();
            $table->double('order_tax', 25, 2)->nullable();
            $table->double('order_discount')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->double('coupon_discount', 25, 2)->nullable();
            $table->double('shipping_cost', 25, 2)->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('payment_status')->default(0);
            $table->foreignIdFor(Media::class)->nullable()->constrained();
            $table->double('paid_amount', 25, 2)->nullable();
            $table->string('type');
            $table->string('payment_method')->default('Cash');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
