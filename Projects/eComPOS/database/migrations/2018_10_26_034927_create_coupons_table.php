<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('type');
            $table->double('amount', 25, 2)->default(0);
            $table->double('min_amount', 25, 2)->nullable();
            $table->double('max_amount', 25, 2)->nullable();
            $table->integer('qty')->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->integer('used')->default(0);
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
