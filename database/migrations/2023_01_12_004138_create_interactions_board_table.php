<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsBoardTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('interactions_board', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_interaction')->constrained()->references('id')->on('interactions');
      $table->integer('life');
      $table->integer('damage');
      $table->integer('strength');
      $table->integer('dexterity');
      $table->integer('constitution');
      $table->integer('intelligence');
      $table->integer('wisdom');
      $table->integer('charisma');
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
    Schema::dropIfExists('interactions_board');
  }
}
