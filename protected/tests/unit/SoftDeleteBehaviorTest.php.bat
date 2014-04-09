cd /d d:\htdocs\test\protected\tests\
echo =============================  >> d:\htdocs\test\protected\tests\unit\SoftDeleteBehaviorTest-log.txt
date /t >> d:\htdocs\test\protected\tests\unit\SoftDeleteBehaviorTest-log.txt
time /t >> d:\htdocs\test\protected\tests\unit\SoftDeleteBehaviorTest-log.txt
echo unit/SoftDeleteBehaviorTest.php >> d:\htdocs\test\protected\tests\unit\SoftDeleteBehaviorTest-log.txt
phpunit unit/SoftDeleteBehaviorTest.php >> d:\htdocs\test\protected\tests\unit\SoftDeleteBehaviorTest-log.txt

