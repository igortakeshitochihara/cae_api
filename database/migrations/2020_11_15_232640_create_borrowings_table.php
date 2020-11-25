<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->uuid('hash');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->dateTime('borrowing_time');
            $table->dateTime('return_time')->nullable();

            // key
            $table->bigInteger('key_id')->unsigned();
            $table->foreign('key_id')->references('id')->on('keys')->onDelete('cascade');

            // user
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowings');
    }
}
