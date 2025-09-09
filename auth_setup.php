<?php
shell_exec('composer require laravel/ui');
shell_exec('php artisan ui bootstrap --auth');
shell_exec('npm install && npm run dev');
shell_exec('php artisan migrate');
echo "Authentication scaffolding installed!";
?>
