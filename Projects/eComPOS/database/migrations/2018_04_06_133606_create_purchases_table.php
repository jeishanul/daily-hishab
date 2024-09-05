<?php

use App\Models\Media;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Warehouse::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'supplier_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Tax::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('total_products');
            $table->integer('total_qty');
            $table->double('total_discount', 25, 2);
            $table->double('total_tax', 25, 2);
            $table->double('total_cost', 25, 2);
            $table->double('order_tax_rate', 25, 2)->nullable();
            $table->double('order_tax', 25, 2)->nullable();
            $table->double('order_discount', 25, 2)->nullable();
            $table->double('shipping_cost', 25, 2)->nullable();
            $table->double('grand_total', 25, 2);
            $table->double('paid_amount', 25, 2)->nullable();
            $table->boolean('payment_status')->default(false);
            $table->string('payment_method')->nullable();
            $table->foreignIdFor(Media::class)->nullable()->constrained();
            $table->timestamp('date')->nullable();
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
        Schema::dropIfExists((new Purchase())->getTable());
    }
}
