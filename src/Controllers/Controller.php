<?php
namespace App\Controllers;

use Jenssegers\Blade\Blade;

class Controller {

  private $viewBuilder;

  public function __construct() {
    $this->viewBuilder = new Blade( SD_PLUGIN_PATH . '/src/frontend', SD_PLUGIN_PATH . '/src/cache' );
  }

  protected function generateView(String $page, array $variables) {
    return $this->viewBuilder->make($page, $variables);
  }

}
