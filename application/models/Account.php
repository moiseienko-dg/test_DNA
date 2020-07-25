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
    if (empty($user_info)) {
      $this->error = 'This login doesn\'t exists';
      return false;
    }
    else {
      $user_info = explode(',', $user_info);
      if ($user_info[1] != $password) {
        $this->error = 'This not your password';
        return false;
      }
    }
    return true;
  }

  public function login($login) {
		$_SESSION['authorize']['name'] = $login;
	}

}

 ?>
