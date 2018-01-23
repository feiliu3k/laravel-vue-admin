<?php

namespace App\Repositories;

use App\Repositories\BaseInterface\Repository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository extends Repository implements RoleRepositoryInterface {

  public function model() {
    return "App\Models\Role";
  }

}
