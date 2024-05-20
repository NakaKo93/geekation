<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('pet_id'); 
            $table->unsignedBigInteger('user_id');
            $table->string('photo_address')->nullable();
            $table->string('name', 100);
            $table->integer('age');
            $table->boolean('gender');
            $table->string('type', 100);
            $table->date('birth');
            $table->date('adoption');
            $table->text('memo')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
