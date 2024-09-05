<?php

use App\Models\Account;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Payment())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Sale::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Account::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('reference');
            $table->double('amount', 25, 2);
            $table->string('payment_method');
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
        Schema::dropIfExists((new Payment())->getTable());
    }
}
