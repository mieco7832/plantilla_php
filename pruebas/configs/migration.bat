@echo off
php -r " namespace Configs; require 'Migration.php'; $objeto = new Migration(); $objeto->runMigration();"

timeout /t 5 > nul

pause