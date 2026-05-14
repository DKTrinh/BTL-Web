<?php
// Kiểm tra quyền truy cập trực tiếp (nếu cần)
if (!isset($comments)) {
    die("Dữ liệu không tồn tại.");
}
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary">
                        <i class="fas fa-comments me-2"></i>Quản lý Bình luận
                    </h5>
                    <form action="public_entry.php" method="GET" class="d-flex">
                        <input type="hidden" name="url" value="admin/comments">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               placeholder="Tìm nội dung..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Người gửi</th>
                                    <th style="width: 200px;">Bài viết</th>
                                    <th>Nội dung bình luận</th>
                                    <th style="width: 150px;">Ngày đăng</th>
                                    <th style="width: 100px;" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($comments)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Không tìm thấy bình luận nào.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($comments as $cmt): ?>
                                        <tr>
                                            <td><?= $cmt['id'] ?></td>
                                            <td>
                                                <span class="fw-bold text-dark"><?= htmlspecialchars($cmt['user_name']) ?></span>
                                            </td>
                                            <td>
                                                <small class="text-truncate d-inline-block" style="max-width: 180px;">
                                                    <?= htmlspecialchars($cmt['news_title']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="text-wrap" style="max-width: 400px;">
                                                    <?= htmlspecialchars($cmt['content']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    <?= date('d/m/Y H:i', strtotime($cmt['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="public_entry.php?url=admin/comments/delete&id=<?= $cmt['id'] ?>" 
                                                   class="btn btn-outline-danger btn-sm" 
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này không?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 10px; }
    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-top: none;
    }
    .text-wrap {
        word-break: break-word;
        font-size: 0.9rem;
    }
</style>