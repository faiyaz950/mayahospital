<?php
/**
 * Maya Hospital — site settings.
 *
 * Change phone numbers, address or doctors here and every page updates.
 * Server secrets (database password, admin password) do NOT go in this file:
 * put them in includes/config.local.php, which overrides anything below
 * and is never committed to git. See DEPLOYMENT.md.
 */

$config = [
    'site' => [
        'name'           => 'Maya Hospital',
        'city'           => 'Farrukhabad',
        'tagline'        => 'Specialized Care. Personal Attention. Better Health.',
        'url'            => 'https://maya-hospital.in',
        'phone_booking'  => '+91 96480 46798',
        'phone_helpline' => '+91 77740 47404',
        'phone_extra'    => '+91 95329 97024',
        'address'        => 'Awas Vikas Tiraha, Barhpur, Farrukhabad, Uttar Pradesh – 209625',
        'address_short'  => 'Awas Vikas Tiraha, Barhpur, Farrukhabad',
        'maps_query'     => 'Maya Hospital Awas Vikas Tiraha Barhpur Farrukhabad',
    ],

    // Options shown in the appointment form (and accepted by the server).
    'departments' => [
        'Pain Management',
        'Spine & Joint Care',
        'IVF & Fertility',
        'Obstetrics & Gynaecology',
    ],
    'doctors' => [
        'Dr. Satish Rajput',
        'Dr. Poonam Sharma',
    ],

    // Database. Local default is a SQLite file in /data; on Hostinger set a
    // MySQL DSN in config.local.php, e.g. 'mysql:host=localhost;dbname=u123_maya;charset=utf8mb4'.
    'db' => [
        'dsn'  => 'sqlite:' . __DIR__ . '/../data/maya.sqlite',
        'user' => null,
        'pass' => null,
    ],

    // New appointment requests are emailed here (leave empty to disable).
    'mail' => [
        'to'   => '',
        'from' => 'no-reply@maya-hospital.in',
    ],

    // Admin panel login (/admin). Generate the hash with:
    //   php -r "echo password_hash('your-strong-password', PASSWORD_DEFAULT), PHP_EOL;"
    'admin' => [
        'user'      => 'admin',
        'pass_hash' => '',
    ],
];

$local = __DIR__ . '/config.local.php';
if (is_file($local)) {
    $config = array_replace_recursive($config, require $local);
}

return $config;
