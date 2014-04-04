<?php
class Car extends CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'car';
    }

    protected function instantiate($attributes) {
        $class = get_class($this);
        $type = $attributes['type'];
        if (@class_exists($type, true)) {
            $class = $type;
        }
        $model = new $class(null);
        return $model;
    }

}
