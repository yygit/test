<?php
class RemoteFileValidator extends CValidator{
    public $code = '';
    public $message = 'Please upload file first.';
    public $skipOnError = false;

    /**
     * @param CModel $object
     * @param string $attribute
     */
    protected function validateAttribute($object, $attribute) {
        if ($object->hasErrors() && $this->skipOnError == TRUE)
            return;

        if (empty($this->code))
            return;

        $value = $object->$attribute;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://' . $value . '/verify.html');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        if (trim($output) != $this->code)
            $this->addError($object, $attribute, $this->message);
    }
}
