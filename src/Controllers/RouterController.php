<?php

namespace App\Controllers;

class RouterController {

  public function get($url, $callback){
    $this->resolveCallback($url, $callback, 'GET');
  }

  public function post($url, $callback){
    $this->resolveCallback($url, $callback, 'POST');
  }

  public function register_admin_page(String $title, String $name, String $callback) {
    $meta = explode('@', $callback);
    $class = 'App\\Controllers\\'.$meta[0];
    $controller = new $class();
    add_action('admin_menu', function() use($title, $name, $controller, $meta) {
      add_submenu_page( sanitize_key(PLUGIN_NAME), PLUGIN_NAME, $title, 'manage_options', sanitize_key($name),  array( $controller, $meta[1] ) );
    });
  }

  /*
    Retorna função correspondente ao callback indicado seguindo o formato:
    controller@function
  */
  private function resolveCallback(String $url, String $callback, String $method){
    try {
      $meta = explode('@', $callback);
      $class = 'App\\Controllers\\'.$meta[0];
      $controller = new $class();
      add_action('rest_api_init', function() use($controller, $meta, $method, $url){
        register_rest_route(URL_SCOPE, $url, [
          'methods' => $method,
          'callback' => function()use($controller, $meta){return $controller->{$meta[1]}();}
        ]);
      });
    } catch (Exception $e) {
      die('Cannot read callback like that');
    }
  }

}
