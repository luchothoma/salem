<?php 
class houses_orm
{
    public $id;
    public $direccion;
    public $precio;
    
    public function info()
    {
        return $this->id.') '.$this->direccion.' $'.$this->precio;
    }
}
 ?>