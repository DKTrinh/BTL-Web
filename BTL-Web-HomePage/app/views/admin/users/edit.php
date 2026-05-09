<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa người dùng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f4f6fa;">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-warning text-dark fw-bold text-center py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">Cập nhật tài khoản</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Quan trọng: Phải có enctype để gửi file -->
                    <form action="public_entry.php?url=user-update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        
                        <!-- Phần cập nhật Avatar -->
                        <div class="text-center mb-4">
                            <img id="previewAvatar" src="<?= !empty($user['avatar']) ? $user['avatar'] : 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>" 
                                 class="rounded-circle border border-3 border-warning" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="mt-2">
                                <label for="avatarInput" class="btn btn-sm btn-outline-dark">Đổi ảnh đại diện</label>
                                <input type="file" name="avatar" id="avatarInput" hidden accept="image/*" onchange="previewFile()">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Họ và Tên</label>
                            <input type="text" name="fullname" class="form-control bg-light" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Email truy cập</label>
                            <input type="email" name="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted small">Phân quyền</label>
                            <select name="role" class="form-select bg-light">
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin (Quản trị viên)</option>
                                <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client (Người dùng thường)</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-bold py-2">Lưu thay đổi</button>
                            <a href="public_entry.php?url=users" class="btn btn-outline-secondary py-2">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewFile() {
    const preview = document.getElementById('previewAvatar');
    const file = document.getElementById('avatarInput').files[0];
    const reader = new FileReader();
    reader.onloadend = function() { preview.src = reader.result; }
    if (file) { reader.readAsDataURL(file); }
}
</script>