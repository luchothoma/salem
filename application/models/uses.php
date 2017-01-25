<?php 
use Salem\load;
load::parentModel('general');
class uses extends general
{
  public function get($val)
  {
    // Return results from a query
    return self::makeQuery('casas','bath','like','%'.$val.'%');
  }
}
 ?>
