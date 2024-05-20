<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petsHealth', function (Blueprint $table) {
            $table->id('pethealth_id');
            $table->unsignedBigInteger('pet_id');
            $table->date('date');
            $table->decimal('weight', 4, 2)->nullable();
            $table->string('breakfast_type', 100)->nullable();
            $table->decimal('breakfast_amount', 4, 2)->nullable();
            $table->string('lunch_type', 100)->nullable();
            $table->decimal('lunch_amount', 4, 2)->nullable();
            $table->string('dinner_type', 100)->nullable();
            $table->decimal('dinner_amount', 4, 2)->nullable();
            $table->string('medicine', 100)->nullable();
            $table->integer('walk')->nullable();
            $table->boolean('trimming')->nullable();
            $table->integer('toilet')->nullable();
            $table->text('memo')->nullable();

            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');

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
        Schema::dropIfExists('petsHealth');
    }
}
