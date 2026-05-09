<style>
    .profile-container { margin-top: -50px; position: relative; z-index: 10; }
    .profile-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #fff; }
    .profile-sidebar { background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .nav-pills-custom .nav-link { color: #64748b; font-weight: 600; padding: 12px 20px; border-radius: 10px; margin-bottom: 10px; transition: 0.3s; }
    .nav-pills-custom .nav-link.active { background-color: var(--primary-blue); color: #fff; }
    .nav-pills-custom .nav-link:hover:not(.active) { background-color: #f1f5f9; color: var(--primary-blue); }
    .form-label { font-weight: 600; color: #475569; font-size: 0.9rem; }
    .form-control-profile { border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px 15px; background-color: #f8fafc; }
    .form-control-profile:focus { background-color: #fff; border-color: var(--primary-blue); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
    .avatar-wrapper { position: relative; width: 150px; height: 150px; margin: 0 auto; }
    .btn-upload-avatar { position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px; border-radius: 50%; background: var(--primary-blue); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff; }
</style>

<!-- Phần Banner trang trí phía trên -->
<div style="height: 200px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);"></div>

<div class="container profile-container mb-5">
    <!-- Hiển thị thông báo Success/Error từ Session -->
    <?php if(isset($_SESSION['success_message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ title: 'Thành công!', text: '<?= $_SESSION['success_message'] ?>', icon: 'success', confirmButtonColor: '#2563eb' });
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Sidebar bên trái -->
        <div class="col-lg-4">
            <div class="profile-sidebar text-center">
                <div class="avatar-wrapper mb-4">
                    <img src="<?= !empty($user['avatar']) ? $user['avatar'] : 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>" 
                         class="rounded-circle border border-4 border-white shadow" style="width: 150px; height: 150px; object-fit: cover;">
                    <label for="avatarInput" class="btn-upload-avatar shadow-sm">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                </div>
                <h4 class="fw-bold mb-1"><?= htmlspecialchars($user['fullname']) ?></h4>
                <p class="text-muted small mb-4"><?= htmlspecialchars($user['email']) ?></p>

                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-info"><i class="bi bi-person-vcard me-2"></i> Thông tin cá nhân</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-password"><i class="bi bi-shield-lock me-2"></i> Đổi mật khẩu</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-orders"><i class="bi bi-bag-check me-2"></i> Lịch sử đơn hàng</button>
                </div>

                <form id="avatarForm" action="public_entry.php?url=profile-avatar" method="POST" enctype="multipart/form-data" class="d-none">
                    <input type="file" name="avatar" id="avatarInput" onchange="document.getElementById('avatarForm').submit();">
                </form>
            </div>
        </div>

        <!-- Nội dung bên phải -->
        <div class="col-lg-8">
            <div class="card profile-card">
                <div class="card-body p-4 p-md-5">
                    <div class="tab-content" id="v-pills-tabContent">
                        
                        <!-- Tab 1: Cập nhật thông tin -->
                        <div class="tab-pane fade show active" id="tab-info">
                            <h5 class="fw-bold mb-4">Cập nhật thông tin cá nhân</h5>
                            <form action="public_entry.php?url=profile-update" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Họ và Tên</label>
                                        <input type="text" name="full_name" class="form-control form-control-profile" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control form-control-profile" value="<?= htmlspecialchars($user['email']) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control form-control-profile" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ngày sinh</label>
                                        <input type="date" name="birthdate" class="form-control form-control-profile" value="<?= $user['birthdate'] ?? '' ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Giới tính</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="male" id="g-male" <?= ($user['gender'] ?? '') == 'male' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="g-male">Nam</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="female" id="g-female" <?= ($user['gender'] ?? '') == 'female' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="g-female">Nữ</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Tiểu sử (Bio)</label>
                                        <textarea name="bio" class="form-control form-control-profile" rows="4"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary-custom mt-4 px-5">Lưu thay đổi</button>
                            </form>
                        </div>

                        <!-- Tab 2: Đổi mật khẩu -->
                        <div class="tab-pane fade" id="tab-password">
                            <h5 class="fw-bold mb-4">Đổi mật khẩu bảo mật</h5>
                            <form action="public_entry.php?url=profile-password" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" name="current_password" class="form-control form-control-profile" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" name="new_password" class="form-control form-control-profile" required minlength="6">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                    <input type="password" name="confirm_password" class="form-control form-control-profile" required minlength="6">
                                </div>
                                <button type="submit" class="btn btn-danger fw-bold px-5 py-2 rounded-3">Cập nhật mật khẩu</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đảm bảo đã nhúng SweetAlert2 ở footer hoặc trang chủ để hiện popup đẹp -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>