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
      return R::getRow("SELECT * FROM $tableName WHERE id = ?", [$id]);
    }

    public static function findBy($attribute, $value){
      $tableName = self::$table;
      return R::getRow("SELECT * FROM $tableName WHERE $attribute = ? LIMIT 1", [$value]);
    }

    public static function findAll(){
      $tableName = self::$table;
      return R::getAll("SELECT * FROM $tableName");
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
  

    public function delete()
    {
      
    }
    
    protected function update()
    {
    
    }

    public function save()
    {
        $table_name = self::$table;
        $attributes = get_object_vars($this);
        $attribute_names = array_keys($attributes);
        $query = "INSERT INTO $table_name (".join(',', $attribute_names).") VALUES (".join(',', array_map(function ($item) { return '?';}, $attribute_names)).")";
        R::exec($query, $attribute_names);
        return 1;
    }

    protected static function tableName()
    {
      $class_name = strtolower(get_called_class());
      if (preg_match("/{'_'}/i", $class_name)) { return $class_name; }
      return $class_name[count($class_name) - 1] == 'y' ? substr_replace($class_name, "ies", count($class_name)-1) : $class_name."s";
    }

}