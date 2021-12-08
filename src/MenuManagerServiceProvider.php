<?php

namespace DevSobSud\MenuManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use DevSobSud\MenuManager\View\Components\AppLayout;

class MenuManagerServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'menu');
  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__.'/../config/config.php' => config_path('menu.php'),
      ], 'config');

      if (! class_exists('CreatePostsTable')) {
        $this->publishes([
          __DIR__ . '/../database/migrations/create_menus_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_menus_table.php'),
        ], 'migrations');
      }

      $this->publishes([
        __DIR__.'/../src/View/Components/' => app_path('View/Components'),
        __DIR__.'/../resources/views/components/' => resource_path('views/components'),
      ], 'view-components');
    }

    $this->publishes([
        __DIR__.'/../resources/assets' => public_path('vendor/menu'),
      ], 'assets');

    $this->registerRoutes();
    $this->loadViewComponentsAs('menumanager', [
      AppLayout::class,
    ]);
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'menumanager-views');
  }

  protected function registerRoutes()
  {
      Route::group($this->routeConfiguration(), function () {
          $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
      });
  }

  protected function routeConfiguration()
  {
      return [
          'prefix' => config('menu.prefix'),
          'middleware' => config('menu.middleware'),
      ];
  }
}
