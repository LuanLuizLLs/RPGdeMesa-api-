<?php

namespace Repositories;

use Commons\Response;
use Entities\UserEntity;

interface UserRepository {
  public function create(UserEntity $request): Response;
  public function read(UserEntity $request): Response;
  public function update(UserEntity $request): Response;
  public function delete(UserEntity $request): Response;
}
