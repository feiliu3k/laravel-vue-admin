<?php

namespace App\Repositories;

use App\Repositories\BaseInterface\Repository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository extends Repository implements PermissionRepositoryInterface {

  public function model() {
    return "App\Models\Permission";
  }

}
