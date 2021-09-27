<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * اذا تم الايداع (زيادة) (عليه) فيسجل مدينا
         * واذا تم السحب (النقص) (له) فيسجل دائنا
         */
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 20, 2);
            $table->enum('transaction_type', ['add', 'subtract']);
            $table->text('note')->nullable();
            $table->bigInteger('wallet_id')->unsigned();
            $table->bigInteger('transactionable_id')->unsigned();
            $table->string('transactionable_type', 191)->comment('دائن');
            $table->bigInteger('balance_transactionable_id')->unsigned();
            $table->string('balance_transactionable_type', 191)->comment('مدين');
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
        Schema::dropIfExists('balance_transactions');
    }
}
