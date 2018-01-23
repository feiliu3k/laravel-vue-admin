<?php
/**
 * Created by PhpStorm.
 * User: zxwwjs@hotmail.com
 * Date: 2017-6-28
 * Time: 22:04
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    
    $this->app->bind('App\Repositories\Contracts\CategoryRepositoryInterface','App\Repositories\CategoryRepository');
    $this->app->bind('App\Repositories\Contracts\PatternRepositoryInterface','App\Repositories\PatternRepository');
    $this->app->bind('App\Repositories\Contracts\PermissionRepositoryInterface','App\Repositories\PermissionRepository');
    $this->app->bind('App\Repositories\Contracts\RoleRepositoryInterface','App\Repositories\RoleRepository');
    $this->app->bind('App\Repositories\Contracts\UserRepositoryInterface','App\Repositories\UserRepository');
    
  }
}
