<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('abilities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_character')->constrained()->references('id')->on('characters');
      $table->string('name')->nullable();
      $table->string('description')->nullable();
      $table->string('attribute')->nullable();
      $table->integer('level')->nullable();
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
    Schema::dropIfExists('abilities');
  }
}
