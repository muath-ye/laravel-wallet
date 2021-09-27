<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 20, 2);
            $table->text('note')->nullable();
            $table->bigInteger('wallet_id')->unsigned();
            $table->bigInteger('dispositable_id')->unsigned();
            $table->string('dispositable_type', 191)
                ->comment('Disposter admins, points, referals or etc..');
            $table->bigInteger('approved_by')->unsigned()->nullable();
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
        Schema::dropIfExists('deposits');
    }
}
