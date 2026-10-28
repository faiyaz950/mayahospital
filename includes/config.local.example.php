<?php
/**
 * Copy this file to config.local.php on the server and fill in real values.
 * config.local.php is ignored by git, so passwords never end up in the repository.
 */
return [
    'db' => [
        // Hostinger → Databases → MySQL Databases shows these values.
        'dsn'  => 'mysql:host=localhost;dbname=YOUR_DB_NAME;charset=utf8mb4',
        'user' => 'YOUR_DB_USER',
        'pass' => 'YOUR_DB_PASSWORD',
    ],
    'mail' => [
        'to'   => 'appointments@maya-hospital.in',
        'from' => 'no-reply@maya-hospital.in',
    ],
    'admin' => [
        'user'      => 'admin',
        // php -r "echo password_hash('your-strong-password', PASSWORD_DEFAULT), PHP_EOL;"
        'pass_hash' => '',
    ],
];
