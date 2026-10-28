<?php
/**
 * Loaded by every page: settings, session, helpers and the database.
 */
declare(strict_types=1);

$config = require __DIR__ . '/config.php';
$site   = $config['site'];

date_default_timezone_set('Asia/Kolkata');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_name('maya_sess');
    session_start();
}

/** Escape text for HTML output. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** "+91 96480 46798" -> "+919648046798" for tel: links. */
function tel(string $phone): string
{
    return preg_replace('/[^0-9+]/', '', $phone);
}

/** Link to a page by its clean name: url('about') -> "/about", url('home') -> "/". */
function url(string $page = 'home', string $hash = ''): string
{
    $path = $page === 'home' ? '/' : '/' . $page;
    return $path . ($hash !== '' ? '#' . $hash : '');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

/** Shared PDO connection; creates the appointments table on first use. */
function db(): PDO
{
    static $pdo = null;
    global $config;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = $config['db']['dsn'];
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    $isSqlite = str_starts_with($dsn, 'sqlite:');
    $pdo->exec($isSqlite
        ? 'CREATE TABLE IF NOT EXISTS appointments (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               name TEXT NOT NULL, phone TEXT NOT NULL, department TEXT NOT NULL,
               doctor TEXT, preferred_date TEXT, message TEXT,
               status TEXT NOT NULL DEFAULT \'new\', ip TEXT, created_at TEXT NOT NULL)'
        : 'CREATE TABLE IF NOT EXISTS appointments (
               id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
               name VARCHAR(100) NOT NULL, phone VARCHAR(20) NOT NULL, department VARCHAR(60) NOT NULL,
               doctor VARCHAR(60) NULL, preferred_date DATE NULL, message TEXT NULL,
               status VARCHAR(20) NOT NULL DEFAULT \'new\', ip VARCHAR(45) NULL, created_at DATETIME NOT NULL,
               INDEX (status), INDEX (created_at)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    return $pdo;
}
