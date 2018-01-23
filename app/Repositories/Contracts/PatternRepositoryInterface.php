<?php

namespace App\Repositories\Contracts;

use App\Repositories\BaseInterface\RepositoryInterface;


/**
 * Created by PhpStorm.
 * User: zxwwjs@hotmail.com
 */
interface PatternRepositoryInterface extends RepositoryInterface
{

    public function get_all();
}
