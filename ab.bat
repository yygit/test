cd /d c:\xampp\apache\bin\
echo ----------------------------------- >> d:\htdocs\test\ab.exe.txt
echo ab.exe >> d:\htdocs\test\ab.exe.txt
ab -n 100 -c 1 http://localhost/test/site/contact >> d:\htdocs\test\ab.exe.txt
rem ab -n 50 -c 1 http://localhost/test/project/index >> d:\htdocs\test\ab.exe.txt
