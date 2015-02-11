<?php
class TestController extends CController{
    public $layout = 'column1';

    /**
     * http://localhost/test/test/index/song/5
     *
     * @param $song
     */
    public function actionIndex($song) {
        $lyric = 'Nothing was found.';

        // importing a class
        Yii::import('application.apis.lyrics.LyricsFinder');

        $finder = new LyricsFinder();

        if (!empty($song))
            $lyric = $finder->getText($song);

//        echo $lyric;
        $this->renderText($lyric);
    }

    /**
     * confirm domain by domain name and confirmation code
     *
     * http://localhost/test/test/confirm
     */
    public function actionConfirm() {
        $confirmArr = Yii::app()->request->getParam('Confirm');
        $paramArr = array();
        $paramArr['url'] = isset($confirmArr['url']) ? $confirmArr['url'] : NULL;
        $paramArr['code'] = isset($confirmArr['code']) ? $confirmArr['code'] : NULL;
        $paramArr = array_filter($paramArr);
        $model = empty($paramArr) ? new Confirm('confirm') : Confirm::model()->findByAttributes($paramArr);
        $model = empty($model) ? new Confirm('confirm') : $model;

        $confirmed = FALSE;
        $confirmedMessage = Confirm::$confirmedMessage;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'confirm-confirm-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Confirm'])) {
            $model->attributes = $_POST['Confirm'];
            if ($model->validate()) {
                $model->setConfirmed();
                $confirmedMessage = 'URL confirmed';
                $confirmed = TRUE;
            }
        }

        $this->render('confirm', array('model' => $model, 'confirmed' => $confirmed, 'confirmedMessage' => $confirmedMessage));
    }

}
