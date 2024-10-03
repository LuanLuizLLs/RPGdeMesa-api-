<?php

namespace UseCase;

use AlreadyExistsError;
use Entities\UserEntity;
use Repositories\UserRepository;

class UserUseCase {
  private $controller;

  public function __construct(UserRepository $controller) {
    $this->controller = new $controller;
  }

  public function createUser(UserEntity $request) {
    $user = $this->controller->read($request);

    if ($user) {
      return new AlreadyExistsError();
    }

    $this->controller->create($request);
  }
}