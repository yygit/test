<?php
class SoftDeleteBehaviorTest extends CDbTestCase{
    protected $fixtures = array(
        'post' => 'Post',
    );

    function testRemoved() {
        $postCount = Post::model()->removed()->count();
        $this->assertEquals(2, $postCount);
    }

    function testNotRemoved() {
        $postCount = Post::model()->notRemoved()->count();
        $this->assertEquals(3, $postCount);
    }

    function testRemove() {
        $post = Post::model()->findByPk(1);
        $post->remove()->save();

        $this->assertNull(Post::model()->notRemoved()->findByPk(1));
    }

    function testRestore() {
        $post = Post::model()->findByPk(2);
        $post->restore()->save();

        $this->assertNotNull(Post::model()->notRemoved()->findByPk(2));
    }

    function testIsDeleted() {
        $post = Post::model()->findByPk(1);
        $this->assertFalse($post->isRemoved());

        $post = Post::model()->findByPk(2);
        $this->assertTrue($post->isRemoved());
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
            Yii::app()->getDb()->active = false;
    }

}
