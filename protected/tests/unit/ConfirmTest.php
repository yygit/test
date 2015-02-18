<?php
class ConfirmTest extends CDbTestCase{
    protected $fixtures = array(
        'confirm' => 'Confirm',
    );

    function testCount() {
        $linksCount = Confirm::model()->count();
        $this->assertEquals(2, $linksCount);
    }

    function testConfirmValidation() {
        $model = new Confirm();
        $model->url = 'localhost';
        $this->assertFalse($model->validate());
        $this->assertEquals(1, count($model->getErrors()));
        $this->assertTrue($model->hasErrors('code'));
        $this->assertFalse($model->hasErrors('url'));
        $this->assertFalse($model->hasErrors('isconfirmed'));

        $model->url = 'localhost';
        $model->code = '123';
        $this->assertFalse($model->validate());
        $this->assertEquals(1, count($model->getErrors()));
        $this->assertTrue($model->hasErrors('code'));
        $this->assertFalse($model->hasErrors('url'));

        $model->url = 'non_existent_link';
        $this->assertFalse($model->validate());
        $this->assertEquals(2, count($model->getErrors()));
        $this->assertTrue($model->hasErrors('code'));
        $this->assertTrue($model->hasErrors('url'));
    }

    function testAlreadyConfirmed() {
        $model = new Confirm();
        /* the link 'prohor' should already be confirmed
         * only 1 error should be added - 'url already confirmed' */
        $model->url = 'prohor';
        $this->assertFalse($model->validate());
        $this->assertEquals(1, count($model->getErrors()));
    }

    public static function setUpBeforeClass() {
        if (!extension_loaded('pdo') || !extension_loaded('pdo_mysql'))
            self::markTestSkipped('PDO and pdo_mysql extensions are required.');

        /* another test in a group (CouponTest.php) changes configuration
         * this intends to reset config to its original state   */
        $config = require(dirname(__FILE__) . '/../../config/test.php');
        Yii::app()->configure($config);
    }

    /*protected function setUp() {
        parent::setUp();
        $_GET['existing_code'] = 'discount_for_me';
        $_GET['non_existing_code'] = 'non_existing';
    }*/

    public static function tearDownAfterClass() {
        if (Yii::app()->getDb())
            Yii::app()->getDb()->active = FALSE;
    }

}
