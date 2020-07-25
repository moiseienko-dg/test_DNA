<?php

  use application\core\Router;
  require 'application/lib/dev.php';

  spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class . '.php');
    if (file_exists($path)) {
      require $path;
    }
  });

  session_start();
  $router = new Router;
  $router->run()
 ?>
