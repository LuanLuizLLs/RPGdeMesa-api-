<?php

class AlreadyExistsError extends Exception {
  public function __construct() {
    $this->message = 'Dado já existe';
  }
}