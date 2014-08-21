<?php 
use Salem\db;

class general_model
{
  public function makeQuery($table, $field, $operation, $value)
  {
    // Return results from a query
    return db::db($table)->select('*')->where($field,$operation,$value)->execute();
  }
}
 ?>