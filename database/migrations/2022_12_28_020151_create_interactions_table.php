<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('interactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_adventure')->constrained()->references('id')->on('adventures');
      $table->string('name');
      $table->string('description');
      $table->integer('life');
      $table->integer('damage');
      $table->integer('strength');
      $table->integer('dexterity');
      $table->integer('constitution');
      $table->integer('intelligence');
      $table->integer('wisdom');
      $table->integer('charisma');
      $table->softDeletes();
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
    Schema::dropIfExists('interactions');
  }
}
