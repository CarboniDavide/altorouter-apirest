<?php

class Model
{

    protected $table;

    function init() {
      $this->table = static::tableName();
    }
    
    public static function find($id)
    {
     
    }

  public static function findBy($attribute, $value)
  {
   
  }

  public static function findAll()
  {
   
  }

  public static function findAllBy($attribute, $value)
  {
   
  }
  
  
  public function save()
  {
    
  }
  
  public function destroy()
  {
    
  }
  
  protected function update()
  {
   
  }

  protected function insert()
  {
   
  }

  protected static function tableName()
  {
    $class_name = strtolower(get_called_class());
    preg_match('/\\\\(.+?)$/', $class_name, $matches);
    return preg_match("/{'_'}/i", $class_name) ? $matches[1] : $matches[1]."s";
  }

}