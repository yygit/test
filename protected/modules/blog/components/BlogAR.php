<?php

class BlogAR extends CActiveRecord{

    private static $db_blog = null;

    public function getDbConnection() {
        if (self::$db_blog !== null)
            return self::$db_blog;
        else {
            self::$db_blog = Yii::app()->db_blog;
            if (self::$db_blog instanceof CDbConnection)             {
                self::$db_blog->setActive(true);
                return self::$db_blog;
            }
            else throw new CDbException(Yii::t('yii','Active Record requires a "db_blog" CDbConnection application component.'));
        }

    }

}
