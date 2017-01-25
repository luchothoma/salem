<?php
use Salem\db;

class house
{
  public function get($name)
  {
    // Return results from a query
    return db::db('casas')->select('*')->where('bath','like',"%".$name."%")->execute();
  }
}

?>
