<?php
require_once('../../config/database.php');

if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];

    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
    $stmt->execute([$id]);
    $comment = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $comment_text = $_POST['comment'];
        $status = $_POST['status'];

        $stmt = $pdo->prepare("UPDATE comments SET name=?, comment=?, status=? WHERE id=?");
        $stmt->execute([$name, $comment_text, $status, $id]);

        header("Location: comments.php");
        exit;
    } elseif (isset($_POST['add'])) {
        $post_id = $_POST['post_id'];
        $name = $_POST['name'];
        $comment_text = $_POST['comment'];
        $status = $_POST['status'];

        $stmt = $pdo->prepare("INSERT INTO comments (post_id, name,comment, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$post_id,$name, $comment_text, $status]);

        header("Location: comments.php");
        exit;
    }
}

$comments = $pdo->query("
    SELECT comments.*, posts.title 
    FROM comments
    JOIN posts ON comments.post_id = posts.id
    ORDER BY comments.created_at DESC
")->fetchAll();

$posts = $pdo->query("SELECT * FROM posts")->fetchAll();

$pageTitle = 'Comments';

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="py-4">

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3 mb-3">
                    <h2 class="h3 fw-bold mb-1">15</h2>
                    <p class="mb-0">Total comments</p>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white p-3 mb-3" style="background-color: #198754;">
                    <h2 class="h3 fw-bold mb-1">8</h2>
                     <p class="mb-0">Pending</p>
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white p-3 mb-3" style="background-color: #ffc107;">
                    <h2 class="h3 fw-bold mb-1">5</h2>
                    <p class="mb-0">Approved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark text-white p-3 mb-3">
                    <h2 class="h3 fw-bold mb-1">2</h2>
                    <p class="mb-0">Rejected</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Comments</h1>
        </div>

        <?php if (isset($comment) && $comment): ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Comment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="comments.php">
                    <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($comment['name']); ?>">
                    </div>

                   

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?php if($comment['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="approved" <?php if($comment['status'] == 'approved') echo 'selected'; ?>>Approved</option>
                            <option value="rejected" <?php if($comment['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment *</label>
                        <textarea name="comment" class="form-control" rows="3" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="comments.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <?php else: ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Comment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="comments.php">
                    <div class="mb-3">
                        <label class="form-label">Post</label>
                        <select name="post_id" class="form-select" required>
                            <option value="">Select Post</option>
                            <?php foreach ($posts as $post): ?>
                                <option value="<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

        

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment *</label>
                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="add" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Comments</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment['id']; ?></td>
                                <td><?php echo htmlspecialchars($comment['name']); ?></td>

                                <td><?php echo htmlspecialchars($comment['title']); ?></td>
                                <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                                <td>
                                    <?php if ($comment['status'] == 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif ($comment['status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo date('M j, Y', strtotime($comment['created_at'])); ?>
                                </td>
                                <td>
                                    <a href="comments.php?edit_id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$comments): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No comments yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</main>

<?php include '../includes/footer.php'; ?>