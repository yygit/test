<?php
class SportCar extends Car{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function defaultScope() {
        return array(
            'condition' => "type='SportCar'",
        );
    }

    public function init() {
        parent::init();
        $this->attachEventHandler('onAfterFind', array($this, 'beautifyName'));
    }

    public function beautifyName(){
        $this->name .= '---zzz';
    }
}
