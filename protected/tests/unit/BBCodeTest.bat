cd /d d:\htdocs\test\protected\tests\
echo =============================  >> d:\htdocs\test\protected\tests\unit\BBCodeTest-log.txt
date /t >> d:\htdocs\test\protected\tests\unit\BBCodeTest-log.txt
time /t >> d:\htdocs\test\protected\tests\unit\BBCodeTest-log.txt
echo unit/BBCodeTest.php >> d:\htdocs\test\protected\tests\unit\BBCodeTest-log.txt
phpunit unit/BBCodeTest.php >> d:\htdocs\test\protected\tests\unit\BBCodeTest-log.txt
