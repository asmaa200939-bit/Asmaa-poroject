<?php
include "../../includes/database.php";
include "../../includes/header.php";
include "../../includes/sidebar.php";
?>

<link rel="stylesheet" href="../../css//bootstrap.min.css">



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Posts Management</h1>
            <a href="add.php" class="btn btn-primary">
                <i class="bi bi-plus-circle "></i> Add New Post
            </a>
        </div>

        <div class="table-responsive-lg">
            <h5 class="card-title mb-0 ">All Post</h5>

            <table
                class="table table-primary">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>content</th>
                        <th>category_id</th>
                        <th>views</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</main>


<script src="../../js/bootstrap.bundle.min.js"></script>

<?php
include "../../includes/footer.php";
?>
