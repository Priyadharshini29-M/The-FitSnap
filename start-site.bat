@echo off
rem Starts the Brix-Tryon website locally. Needs XAMPP with MySQL running.
cd /d "%~dp0"
echo Starting the website at http://localhost:8080/  (admin: http://localhost:8080/admin/)
echo Keep this window open while you use the site. Close it to stop.
start "" "http://localhost:8080/"
"C:\xampp\php\php.exe" -S 127.0.0.1:8080 -t "%~dp0"
