@echo off
start "" "H:\Softwares\_programming\xmapp\xampp-control.exe"
sleep 60
start "" /MIN "cmd" "/C php -f F:\baiduyun\Codes\PHP\laravel\bicycle\artisan fetch:bicycle_data"