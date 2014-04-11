cd /d d:\htdocs\test\protected\
echo =============================  >> d:\htdocs\test\protected\commands\ECleanCommand-log.txt
date /t >> d:\htdocs\test\protected\commands\ECleanCommand-log.txt
time /t >> d:\htdocs\test\protected\commands\ECleanCommand-log.txt
echo ext.clean-command.ECleanCommand >> d:\htdocs\test\protected\commands\ECleanCommand-log.txt
yiic clean all >> d:\htdocs\test\protected\commands\ECleanCommand-log.txt

