
<?php
include "../../config/database.php";
require_once '../includes/header.php';
require_once '../includes/sidebar.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id=?");
    $stmt->execute([$id]);

    header("Location:post.php");
  
}

$posts = $pdo->query("SELECT * FROM posts");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.mi
n.css" rel="stylesheet">
   
</head>
<body>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="container mt-4">

    <h1 class="text-center text-primary text-capitalize">all posts</h1>

    <a href="createposts.php" class="btn btn-primary my-3">Add Post</a>

    <div class="table-responsive">
        <table class="table table-light">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">content</th>
                    <th scope="col">category</th>
                    <th scope="col">status</th>
                    <th scope="col">action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><?= $post['id'] ?></td>
                        <td><?= $post['title'] ?></td>
                        <td><?= $post['content'] ?></td>
                        <td><?= $post['category_id'] ?></td>
                        <td><?= $post['status'] ?></td>
                        <td>
                            <a href="createpost.php?id=<?= $post['id'] ?>" class="btn btn-primary">Edit</a>

                            <a href="posts.php?delete=<?= $post['id'] ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once '../includes/footer.php'; ?>