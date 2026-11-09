<?php
require_once '../../config/database.php';
require_once '../includes/functions.php';

$message = '';
$message_type = '';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
   ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    set_flash('Invalid category ID.', 'danger');
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, name, description FROM categories WHERE id = ?');
$stmt->execute([$id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    set_flash('Category not found.', 'danger');
    header('Location: index.php');
    exit;
}

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
            $stmt = $pdo->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
            $stmt->execute([$name, $description, $id]);

            set_flash('Category updated successfully!');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            error_log('Category update failed: ' . $e->getMessage());
            $message = 'Could not update category. Please try again.';
            $message_type = 'danger';
        }
    }

    // لو فيه غلط، خلّي الفورم يعرض اللي المستخدم كتبه
    $category['name'] = $name;
    $category['description'] = $description;
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Category #<?php echo (int) $category['id']; ?></h1>
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>

        <?php if ($message !== ''): ?>
            <div class="alert alert-<?php echo e($message_type); ?> alert-dismissible fade show" role="alert">
                <?php echo e($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Category</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="edit.php?id=<?php echo (int) $category['id']; ?>" class="row g-3">
                    <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="id" value="<?php echo (int) $category['id']; ?>">

                    <div class="col-md-4">
                        <label for="categoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryName" name="name"
                               maxlength="255" required value="<?php echo e($category['name']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="categoryDescription" name="description"
                               value="<?php echo e($category['description'] ?? ''); ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </div>

                    <div class="col-12">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>