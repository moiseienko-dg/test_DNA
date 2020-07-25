<?php

namespace application\core;

class Router {

  protected $routes = [];
  protected $params = [];

  public function __construct() {
    $arr = require 'application/config/routes.php';
    foreach ($arr as $key => $val) {
      $this->add($key, $val);
    }
  }

  public function add($route, $params) {
    $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
    $route = '#^' . $route . '$#';
    $this->routes[$route] = $params;
  }

  public function match() {
    $url = trim($_SERVER['REQUEST_URI'], '/');
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        $this->params = $params;
        return true;
      }
    }
    return false;
  }

  public function run() {
    if ($this->match()) {
      $path = 'application\controllers\\' .
       ucfirst($this->params['controller']) . 'Controller';
      $action = $this->params['action'] . 'Action';
      $controller = new $path($this->params);
      $controller->$action();
    }
  }

}


 ?>
