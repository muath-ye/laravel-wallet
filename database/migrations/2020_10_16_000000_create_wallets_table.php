<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('openning_balance', 20, 2);
            $table->decimal('current_balance', 20, 2);
            $table->decimal('frozen_amount', 20, 2)->default(0);
            $table->boolean('status')->default(0);
            $table->bigInteger('walletable_id')->unsigned();
            $table->string('walletable_type', 191)->comment('Owner of this wallet');
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
        Schema::dropIfExists('wallets');
    }
}
