<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

  public function loginAction() {
		if (!empty($_POST)) {
			if (!$this->model->validate(['login', 'password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			elseif (!$this->model->checkNamePassword($_POST['login'], $_POST['password'])) {
				$this->view->message('error', $this->model->error);
			}
			$this->model->login($_POST['login']);
			$this->view->location('/main');
		}
		$this->view->render('Login');
	}

  public function mainAction() {
    $this->view->render('Main');
  }

  public function logoutAction() {
    unset($_SESSION['authorize']);
    $this->view->location('/login');
  }

}


 ?>
