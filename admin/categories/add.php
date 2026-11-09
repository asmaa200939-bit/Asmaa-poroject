<?php
require_once '../../config/database.php';
require_once '../includes/functions.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verify_csrf()) {
        set_flash('Invalid request. Please try again.', 'danger');
        header('Location: index.php');
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '') {
        $message = 'Category name is required!';
        $message_type = 'danger';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
            $stmt->execute([$name, $description]);

            set_flash('Category added successfully!');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            error_log('Category insert failed: ' . $e->getMessage());
            $message = 'Could not add category. Please try again.';
            $message_type = 'danger';
        }
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Add New Category</h1>
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo ($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo ($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Category</h5>
            </div>

            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?php echo (csrf_token()); ?>">

                    <div class="col-md-4">
                        <label for="categoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryName" name="name"
                               maxlength="255" required value="<?php echo ($_POST['name'] ?? ''); ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="categoryDescription" name="description"
                               value="<?php echo ($_POST['description'] ?? ''); ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>