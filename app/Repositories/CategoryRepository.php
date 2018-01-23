<?php

namespace App\Repositories;

use App\Repositories\BaseInterface\Repository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends Repository implements CategoryRepositoryInterface {

  public function model() {
    return "App\Models\Category";
  }

    /**
     * @param int $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate( $perPage = 25, $columns = array( '*' ) ) {

        return $this->model->with('pattern')->paginate( $perPage, $columns );
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find( $id, $columns = array( '*' ) ) {

        return $this->model->with('pattern')->find( $id, $columns );
    }

}
