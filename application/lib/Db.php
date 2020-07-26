<?php

namespace application\lib;

class Db {

  protected $db;

  public function __construct()
  {
    $this->db = 'application/lib/somefile.txt';
  }

  public function get_name($name) {
    $contents = file_get_contents($this->db);
    $pattern = "/^.*$name.*\$/m";
    if (preg_match($pattern, $contents, $mathes)) {
      return $mathes[0];
    }
    return [];
  }

}


 ?>
