<?php
/**
 * Local development only: `php -S localhost:8080 router.php`
 * Mimics the .htaccess rules (clean URLs, blocked folders). Not used on Hostinger.
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/(includes|data)(/|$)|/\.|\.(md|pdf|py|sqlite)$#', $path)) {
    http_response_code(403);
    exit('Forbidden');
}
if (preg_match('#^/(about|services|gallery|contact)$#', $path, $m)) {
    require __DIR__ . "/{$m[1]}.php";
    return true;
}
if (preg_match('#^/(about|services|gallery|contact)\.html$#', $path, $m)) {
    header("Location: /{$m[1]}", true, 301);
    return true;
}
if ($path === '/admin' ) {
    header('Location: /admin/', true, 301);
    return true;
}
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false; // let the built-in server send static files and run .php files
}
if (is_dir($file) && is_file(rtrim($file, '/') . '/index.php')) {
    require rtrim($file, '/') . '/index.php';
    return true;
}
http_response_code(404);
require __DIR__ . '/404.php';
return true;
