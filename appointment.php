<?php
/**
 * Receives the appointment form: validates, stores the request and emails the desk.
 * Answers JSON to the page's fetch() call, or redirects back for plain form posts.
 */
require __DIR__ . '/includes/bootstrap.php';

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

function respond(bool $ok, string $message, array $old = []): never
{
    global $wantsJson;
    if ($wantsJson) {
        http_response_code($ok ? 200 : 422);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message]);
        exit;
    }
    $_SESSION['appointment_flash'] = ['type' => $ok ? 'success' : 'error', 'message' => $message, 'old' => $ok ? [] : $old];
    header('Location: ' . url('contact', 'appointment'), true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . url('contact', 'appointment'), true, 303);
    exit;
}

$in = [
    'name'       => trim((string) ($_POST['name'] ?? '')),
    'phone'      => trim((string) ($_POST['phone'] ?? '')),
    'department' => trim((string) ($_POST['department'] ?? '')),
    'doctor'     => trim((string) ($_POST['doctor'] ?? '')),
    'date'       => trim((string) ($_POST['date'] ?? '')),
    'message'    => trim((string) ($_POST['message'] ?? '')),
];

if (!csrf_valid($_POST['csrf'] ?? null)) {
    respond(false, 'Your session expired. Please refresh the page and try again.', $in);
}

// Bots fill the hidden "website" field; pretend success and store nothing.
if (($_POST['website'] ?? '') !== '') {
    respond(true, 'Thank you! Your appointment request has been received.');
}

// One request per 30 seconds per visitor.
if (time() - ($_SESSION['last_appointment_at'] ?? 0) < 30) {
    respond(false, 'Please wait a few seconds before sending another request.', $in);
}

$digits = preg_replace('/\D/', '', $in['phone']);
$errors = [];
if (mb_strlen($in['name']) < 2 || mb_strlen($in['name']) > 100) {
    $errors[] = 'Please enter the patient name.';
}
if (strlen($digits) < 10 || strlen($digits) > 13) {
    $errors[] = 'Please enter a valid 10-digit mobile number.';
}
if (!in_array($in['department'], $config['departments'], true)) {
    $errors[] = 'Please choose a department.';
}
if ($in['doctor'] !== '' && !in_array($in['doctor'], $config['doctors'], true)) {
    $errors[] = 'Please choose a doctor from the list.';
}
if ($in['date'] !== '') {
    $d = DateTimeImmutable::createFromFormat('!Y-m-d', $in['date']);
    if (!$d || $d->format('Y-m-d') !== $in['date'] || $in['date'] < date('Y-m-d')) {
        $errors[] = 'Please choose today or a future date.';
    }
}
if (mb_strlen($in['message']) > 1000) {
    $errors[] = 'Please keep the message under 1000 characters.';
}
if ($errors) {
    respond(false, implode(' ', $errors), $in);
}

try {
    $stmt = db()->prepare(
        'INSERT INTO appointments (name, phone, department, doctor, preferred_date, message, status, ip, created_at)
         VALUES (:name, :phone, :department, :doctor, :date, :message, \'new\', :ip, :created_at)'
    );
    $stmt->execute([
        ':name'       => $in['name'],
        ':phone'      => $in['phone'],
        ':department' => $in['department'],
        ':doctor'     => $in['doctor'] !== '' ? $in['doctor'] : null,
        ':date'       => $in['date'] !== '' ? $in['date'] : null,
        ':message'    => $in['message'] !== '' ? $in['message'] : null,
        ':ip'         => $_SERVER['REMOTE_ADDR'] ?? null,
        ':created_at' => date('Y-m-d H:i:s'),
    ]);
} catch (Throwable $ex) {
    error_log('Appointment save failed: ' . $ex->getMessage());
    respond(false, 'Sorry, we could not save your request right now. Please call ' . $site['phone_booking'] . '.', $in);
}

$_SESSION['last_appointment_at'] = time();

if ($config['mail']['to'] !== '') {
    $lines = [
        'New appointment request — ' . $site['name'],
        '',
        'Name:        ' . $in['name'],
        'Mobile:      ' . $in['phone'],
        'Department:  ' . $in['department'],
        'Doctor:      ' . ($in['doctor'] ?: 'No preference'),
        'Date:        ' . ($in['date'] ?: 'Not specified'),
        'Message:     ' . ($in['message'] ?: '-'),
        '',
        'Received:    ' . date('d M Y, h:i A'),
        'Manage requests: ' . rtrim($site['url'], '/') . '/admin/',
    ];
    $headers = [
        'From: ' . $site['name'] . ' <' . $config['mail']['from'] . '>',
        'Content-Type: text/plain; charset=UTF-8',
    ];
    $subject = '=?UTF-8?B?' . base64_encode('New appointment: ' . $in['name'] . ' (' . $in['department'] . ')') . '?=';
    if (!@mail($config['mail']['to'], $subject, implode("\n", $lines), implode("\r\n", $headers))) {
        error_log('Appointment email could not be sent.');
    }
}

respond(true, 'Thank you, ' . $in['name'] . '! Your appointment request has been received. Our team will call you on ' . $in['phone'] . ' to confirm the date and time.');
