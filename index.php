<?php
require_once './config/database.php';
$total_posts      = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$published_posts  = $pdo->query("SELECT COUNT(*) FROM posts WHERE status = 'published'")->fetchColumn();
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$pending_comments = $pdo->query("SELECT COUNT(*) FROM comments WHERE status = 'pending'")->fetchColumn();
$total_views      = $pdo->query("SELECT COALESCE(SUM(views), 0) FROM posts")->fetchColumn();


$latest = $pdo->query("SELECT id, title, status, created_at FROM posts ORDER BY created_at DESC LIMIT 5")->fetchAll();

$pageTitle = 'Dashboard';
include './admin/includes/header.php';
include './admin/includes/sidebar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="py-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard Overview</h1>
    </div>

  
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="card text-white bg-primary"><div class="card-body d-flex justify-content-between">
          <div><h4><?php echo $total_posts; ?></h4><p class="mb-0">Posts (<?php echo $published_posts; ?> published)</p></div>
     
        </div></div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success"><div class="card-body d-flex justify-content-between">
          <div><h4><?php echo $total_categories; ?></h4><p class="mb-0">Categories</p></div>
          
        </div></div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning"><div class="card-body d-flex justify-content-between">
          <div><h4><?php echo $pending_comments; ?></h4><p class="mb-0">Pending Comments</p></div>
        
        </div></div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-dark"><div class="card-body d-flex justify-content-between">
          <div><h4><?php echo $total_views; ?></h4><p class="mb-0">Total Views</p></div>
         
        </div></div>
      </div>
    </div>


    <div class="card">
      <div class="card-header"><h5 class="card-title mb-0">Latest Posts</h5></div>
      <div class="card-body">
        <table class="table table-striped mb-0">
          <thead><tr><th>ID</th><th>Title</th><th>Status</th><th>Created</th></tr></thead>
          <tbody>
            <?php foreach ($latest as $p): ?>
              <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo ($p['title']); ?></td>
                <td>
                  <?php if ($p['status'] == 'published'): ?>
                    <span class="badge bg-success">Published</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Draft</span>
                  <?php endif; ?>
                </td>
                <td><?php echo date('M j, Y', strtotime($p['created_at'])); ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (!$latest): ?>
              <tr><td colspan="4" class="text-center text-muted">No posts yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div> 
</main>
<?php include './admin/includes/footer.php'; ?>
