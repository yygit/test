cd /d c:\xampp\apache\bin\
echo ----------------------------------- >> c:\ab.exe.txt
echo ab.exe >> c:\ab.exe.txt
ab -n 100 -c 1 http://localhost/test/site/contact >> c:\ab.exe.txt
