<?php

class Setget extends CComponent{
    private $var1;

    /**
     * @param mixed $var1
     */
    public function setVar1($var1) {
        $this->var1 = $var1 . '-setter-';
    }

    /**
     * @return mixed
     */
    public function getVar1() {
        return $this->var1 . '-getter-';
    }

    public function someFunc() {
        return '12345';
    }


}
