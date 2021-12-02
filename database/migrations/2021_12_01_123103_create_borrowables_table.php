<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowables', function (Blueprint $table) {
            $table->unsignedBigInteger('borrow_id');
            $table->foreign('borrow_id')->references('id')->on('borrows')->onDelete('cascade');
            $table->unsignedBigInteger('borrowable_id');
            $table->string('borrowable_type');
            $table->integer('qty');
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
        Schema::dropIfExists('borrowables');
    }
}
