<?php
class FamilyCar extends Car{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function defaultScope() {
        return array(
            'condition' => "type='FamilyCar'",
        );
    }

    public function init() {
        parent::init();
        $this->attachEventHandler('onAfterFind', array($this, 'capitalizeName'));
    }

    public function capitalizeName(){
        $this->name = strtoupper($this->name);
    }
}
