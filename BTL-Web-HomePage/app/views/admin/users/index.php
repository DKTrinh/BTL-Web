<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f4f6fa;">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Quản lý Thành viên</h2>
        <div>
            <a href="public_entry.php?url=home" class="btn btn-outline-primary me-2">Về Trang chủ</a>
            <a href="public_entry.php?url=logout" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>
    
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($users)): ?>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="ps-4"><strong>#<?= $u['id'] ?></strong></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <?php if($u['role'] === 'admin'): ?>
                                    <span class="badge bg-danger rounded-pill px-3">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-info rounded-pill px-3 text-dark">Client</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $u['status'] == 1 
                                    ? '<span class="badge bg-success rounded-pill px-3">Hoạt động</span>' 
                                    : '<span class="badge bg-secondary rounded-pill px-3">Bị khóa</span>' ?>
                            </td>
                            <td class="text-center py-3">
                                <!-- Nút Sửa -->
                                <a href="public_entry.php?url=user-edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning fw-bold">Sửa</a>
                                
                                <!-- Nút Khóa / Mở khóa -->
                                <a href="public_entry.php?url=user-lock&id=<?= $u['id'] ?>" 
                                   class="btn btn-sm fw-bold <?= $u['status'] == 1 ? 'btn-secondary' : 'btn-success' ?>" 
                                   onclick="return confirm('Xác nhận thay đổi trạng thái tài khoản này?')">
                                    <?= $u['status'] == 1 ? 'Khóa' : 'Mở khóa' ?>
                                </a>

                                <!-- Nút Cấp lại mật khẩu -->
                                <form action="public_entry.php?url=user-reset" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-dark fw-bold" onclick="return confirm('Bạn muốn cấp lại mật khẩu ngẫu nhiên cho người này?')">Reset Pass</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có dữ liệu người dùng.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>