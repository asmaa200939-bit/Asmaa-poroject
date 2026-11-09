<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function csrf_token()
{
    return $_SESSION['csrf_token'];
}

function verify_csrf()
{
    $posted = $_POST['csrf_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'], $posted);
}

function set_flash($message, $type = 'success')
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
function upload_image($file, $dir)
{
    if (empty($file['name'])) {
        return '';
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true) || getimagesize($file['tmp_name']) === false) {
        return false;
    }

    $fileName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $dir . $fileName)) {
        return false;
    }
    return $fileName;
}

function delete_image($fileName, $dir)
{
    if (!empty($fileName) && file_exists($dir . $fileName)) {
        unlink($dir . $fileName);
    }
}