<?php
include "../../includes/database.php";
$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM `categories` WHERE id = ?");
$stmt->execute([$id]);
$categories = $stmt->fetch();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $stmt = $pdo->prepare("UPDATE `categories` SET `name`= ? ,`description`= ?  WHERE id = ?");
    $stmt->execute([$name, $description,$id]);
    header("Location: index.php");
}

?>
<link rel="stylesheet" href="../../css//bootstrap.min.css">
<div class="container">
    <div class="card mt-5">
        <div class="card-body p-3">
            <h1 class="text-center text-light bg-info">Add new Categories</h1>
            <form method="POST">
                <label for="name" class="form-label">name</label>
                <input type="text" name="name" class="form-control" value="<?= $categories["name"] ?>">

                <label for="description" class="form-label">description</label>
                <textarea name="description" class="form-control"><?= $categories["description"] ?></textarea>

                <button type="submit" class="btn btn-info w-100 text-light mt-3">Creat new Categories</button>
            </form>
        </div>
    </div>
</div>
