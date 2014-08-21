<?php 
use Salem\load;
load::parentModel('general');
class uses_model extends general_model
{
  public function get($val)
  {
    // Return results from a query
    return self::makeQuery('casas','bath','like','%'.$val.'%');
  }
}
 ?>