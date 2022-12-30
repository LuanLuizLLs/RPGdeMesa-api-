<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('features', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_character')->constrained()->references('id')->on('characters');
      $table->string('name');
      $table->string('description');
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
    Schema::dropIfExists('features');
  }
}
