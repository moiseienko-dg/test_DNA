<?php

namespace application\core;

use application\core\View;

abstract class Controller {

  public $route;
  public $view;
  public $acl;

  public function __construct($route) {
    $this->route = $route;
    if (!$this->checkAcl()) {
      View::errorCode(403);
    }
    $this->view = new View($route);
    $this->model = $this->loadModel($route['controller']);
  }

  public function loadModel($name) {
    $path = 'application\models\\' . ucfirst($name);
    return new $path;
  }

  public function checkAcl() {
    $this->acl = require 'application/acl/' . $this->route['controller'] . '.php';
    if ($this->isAcl('all')) {
      return true;
    }
    elseif (isset($_SESSION['authorize']['name']) and $this->isAcl('authorize')) {
      return true;
    }
    return false;
  }

  public function isAcl($key) {
    return in_array($this->route['action'], $this->acl[$key]);
  }

}


 ?>
