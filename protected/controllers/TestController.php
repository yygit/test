<?php
class TestController extends CController{
    /**
     * http://localhost/test/test/index/song/5
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
}
