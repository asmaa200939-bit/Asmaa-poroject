<?php
include "../../includes/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title =  $_POST["title"];
    $content = $_POST["content"];
    $category_id = $_POST["category_id"];
    $views = $_POST["views"];
    $status = $_POST["status"];

    $stmt = $pdo->prepare("INSERT INTO posts(title, content, category_id, views,status) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$title ,$content ,$category_id ,$views ,$status]);
    header("Location: index.php");

}

?>
<link rel="stylesheet" href="../../css//bootstrap.min.css">
<div class="container">
    <div class="card mt-5">
        <div class="card-body p-3">
            <h1 class="text-center text-light bg-warning p-3">Add new Post</h1>
            <form method="POST">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control">

                <label for="content" class="form-label">content</label>
                <textarea name="content" class="form-control"></textarea>

                <label for="category_id" class="form-label">category_id</label>
                <input type="text" name="category_id" class="form-control">

                <label for="views" class="form-label">views</label>
                <input type="text" name="views" id="" class="form-control">

                <label for="status" class="form-label">status</label>
                <input type="text" name="status" id="" class="form-control">

                <button type="submit" class="btn btn-warning w-100 text-light mt-3">Creat new Post </button>
            </form>
        </div>
    </div>
</div>


