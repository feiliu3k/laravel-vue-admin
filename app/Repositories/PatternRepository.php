<?php

namespace App\Repositories;

use App\Repositories\BaseInterface\Repository;
use App\Repositories\Contracts\PatternRepositoryInterface;
use App\Models\Pattern;

class PatternRepository extends Repository implements PatternRepositoryInterface {

  public function model() {
    return "App\Models\Pattern";
  }

  public function get_all(){
     return $this->all( ['id','name'] );
  }

}
