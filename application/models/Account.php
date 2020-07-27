<?php

namespace application\models;

use application\core\Model;

class Account extends Model {

  public $error;

  public function validate($input, $post) {
    $required_fields = [
      'login' => 'Login',
      'password' => 'Password'
    ];
    $rules = [
      'login' => [
        'pattern' => '#^[a-z0-9]{3,15}$#',
        'message' => 'First name consists of latin alphabet from 3 to 15 letters',
      ],
      'password' => [
        'pattern' => '#^[a-z0-9]{10,30}$#',
        'message' => 'Password need at least 10 symbol of latin alphabet or numbers',
      ],
    ];
    foreach ($input as $val) {
      if (empty($post[$val]) and in_array($val, array_keys($required_fields))) {
        $this->error = $required_fields[$val] . ' is required field';
        return false;
      }
      elseif (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
        $this->error = $rules[$val]['message'];
        return false;
      }
    }
    return true;
  }

  public function checkNamePassword($login, $password) {
    $user_info = $this->db->get_name($login);
    if (!isset($_SESSION['authorize']['login_attepmts'])) {
      $_SESSION['authorize']['login_attepmts'] = 0;
    }
    if (empty($user_info)) {
      $this->error = 'This login doesn\'t exists';
      return false;
    }
    else {
      $user_info = explode(',', $user_info);
      if ($user_info[1] != $password) {
        $_SESSION['authorize']['login_attepmts'] += 1;
        $this->error = 'This not your password';
        return false;
      }
    }
    return true;
  }

  public function checkLoginAttepmts() {
    if ($_SESSION['authorize']['login_attepmts'] > 2) {
      if (isset($_SESSION['authorize']['locked'])) {
        if (!$this->checkTimeAttepmts()) {
          return false;
        }
      }
      else {
        $_SESSION['authorize']['locked'] = time();
        $this->error = 'Attempts Login exhausted. Wait for: 5 minutes';
        return false;
      }
    }
    return true;
  }

  public function checkTimeAttepmts() {
    $difference = time() - $_SESSION['authorize']['locked'];
    if ($difference < 300) {
      $minutes = intdiv(300-$difference, 60);
      $seconds =  (300-$difference) %  60;
      $this->error = 'Attempts Login exhausted. Wait for: ' .
      $minutes . 'm ' . $seconds . 's';
    }
    else {
      unset($_SESSION['authorize']['locked']);
      unset($_SESSION['authorize']['login_attepmts']);
      return true;
    }
  }

  public function login($login) {
		$_SESSION['authorize']['name'] = $login;
	}

}

 ?>
