<?php
require_once '../../config/database.php';
require_once '../includes/functions.php';

// الحذف بـ POST فقط
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!verify_csrf()) {
    set_flash('Invalid request. Please try again.', 'danger');
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    set_flash('Invalid category ID.', 'danger');
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        set_flash('Category deleted successfully!');
    } else {
        set_flash('Category not found.', 'danger');
    }
} catch (PDOException $e) {
    error_log('Category delete failed: ' . $e->getMessage());
    set_flash('Could not delete category. It may be in use.', 'danger');
}

header('Location: index.php');
exit;