<?php

use App\Models\Account;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class, 'from_account_id')->constrained('accounts')->cascadeOnDelete();
            $table->foreignIdFor(Account::class, 'to_account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('reference_no');
            $table->double('amount', 25, 2);
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
        Schema::dropIfExists('money_transfers');
    }
}
