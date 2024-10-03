<?php

namespace Database;

use Illuminate\Database\Eloquent\Model;

class UserDatabase
{
  public $model;

  public function __construct(Model $model) {
    $this->model = $model;
  }
}
