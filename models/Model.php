<?php

class Model{

    protected static $table = null;

    public static function init() {
      self::$table = self::tableName();
    }
    
    public static function getName(){
      return self::$table;
    }

    public static function find($id){
      $tableName = self::$table;
      
      $row = R::getRow("SELECT * FROM $tableName WHERE id = ?", [$id]);
      if (!$row) return null;

      $product = new Product();

      foreach($row as $key=>$value) {
        $product->$key = $value;
      }

      return $product;
    }

    public static function findBy($attribute, $value){
      $tableName = self::$table;
      return R::getRow("SELECT * FROM $tableName WHERE $attribute = ? LIMIT 1", [$value]);
    }

    public static function findAll(){
      $tableName = self::$table;
      return R::getAll("SELECT * FROM $tableName ORDER BY ID ASC");
    }

    public static function findAllBy($attribute, $value){
      $tableName = self::$table;
      return R::getAll("SELECT * FROM $tableNameable WHERE $attribute = ?", [$value]);
    }

    public static function first(){
      $tableName = self::$table;
      return R::getRow("SELECT * FROM $tableName ORDER BY id ASC LIMIT 0,1");
    }
    
    public static function last(){
      $tableName = self::$table;
      return R::getRow("SELECT * FROM $tableName ORDER BY id DESC LIMIT 0,1");
    }
    
    public static function count(){
      $tableName = self::$table;
      return R::getRow("SELECT COUNT(*) as total_rows FROM $tableName");
    }

    public static function searchBy($attributes_values){
      $query = "";    
      $index = 0;
      $keys = array_keys($attributes_values);
      $values;

      foreach($keys as $key){
        $query = $query . key . " LIKE ?";
        if ($index != count($attributes_values)-1){
          $query = $query . " AND ";
        }
        array_push($values, "%".$attributes_values[key]."%");
      }

      $tableName = self::$table;
      return R::getAll("SELECT * FROM $tableName WHERE $query ORDER BY name ASC", $values );
    }
  

    public function delete(){
      return R::hunt(static::$table, 'id = ?', [ $this->id ]);
    }
    
    public function update(){
      $model = R::dispense( static::$table );
      $attributes = get_object_vars($this);
      foreach($attributes as $key=>$value) {
        $model->$key = $value;
      }

      return R::store( $model );    
    }

    public function save()
    {
        $table_name = self::$table;
        $model = R::dispense( static::$table );

        $attributes = get_object_vars($this);
        $attribute_names = array_keys($attributes);

        foreach($attributes as $key=>$value) {
          $model->$key = $value;
        }
  
        return R::store( $model );
    }

    protected static function tableName()
    {
      $class_name = strtolower(get_called_class());
      if (preg_match("/{'_'}/i", $class_name)) { return $class_name; }
      return $class_name[count($class_name) - 1] == 'y' ? substr_replace($class_name, "ies", count($class_name)-1) : $class_name."s";
    }

}