<?php
class Task extends CFormModel{
    public $title;
    public $text;

    public function rules() {
        return array(
            array('title', 'required'),
            array('title', 'length', 'min' => 2),
            array('text', 'safe'),
        );
    }
}
