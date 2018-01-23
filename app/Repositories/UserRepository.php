<?php

namespace App\Repositories;

use App\Repositories\BaseInterface\Repository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface {

  public function model() {
    return "App\Models\User";
  }

}
