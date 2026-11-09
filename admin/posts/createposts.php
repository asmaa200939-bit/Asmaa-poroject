<?php
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

include "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    $sql = "INSERT INTO posts (title, content, category_id, status)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $title,
        $content,
        $category_id,
        $status
    ]);

    header("Location:post.php");
  
}

$categories = $pdo->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.mi
n.css" rel="stylesheet">
   
</head>

<body>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-5 card py-3">

        <h2 class="text-center text-primary text-capitalize">add post</h2>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea
                    name="content"
                    class="form-control"
                    rows="5"
                    required
                ></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" >
                    <option value="">Select Category</option>

                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </option>
                    <?php } ?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit
            </button>

            <a href="post.php" class="btn btn-secondary">Back</a>

        </form>

    </div>
    </main>

    <script src="bootstrap.bundle.min.js"></script>

</body>
</html>


<?php
require_once '../includes/footer.php';?>
