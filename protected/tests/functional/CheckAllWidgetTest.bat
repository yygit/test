cd /d d:\htdocs\test\protected\tests\
echo =============================  >> d:\htdocs\test\protected\tests\functional\CheckAllWidgetTest-log.txt
date /t >> d:\htdocs\test\protected\tests\functional\CheckAllWidgetTest-log.txt
time /t >> d:\htdocs\test\protected\tests\functional\CheckAllWidgetTest-log.txt
echo functional/CheckAllWidgetTest.php >> d:\htdocs\test\protected\tests\functional\CheckAllWidgetTest-log.txt
phpunit functional/CheckAllWidgetTest.php >> d:\htdocs\test\protected\tests\functional\CheckAllWidgetTest-log.txt
