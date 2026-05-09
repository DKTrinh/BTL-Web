<style>
    /* Nền mờ ảo màu xanh/tím */
    .modal-backdrop.show {
        opacity: 0.9 !important;
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%) !important;
        backdrop-filter: blur(10px);
    }
    
    .auth-modal-content {
        border-radius: 25px;
        overflow: hidden;
        border: none;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    }

    .auth-left {
        background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 50px 40px;
        position: relative;
    }

    .auth-left::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85') center/cover;
        opacity: 0.15; mix-blend-mode: overlay;
    }

    .auth-right { padding: 50px 40px; background: #ffffff; position: relative; }
    
    .form-control-auth {
        background: #f4f6fa;
        border: 2px solid transparent;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .form-control-auth:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: none;
    }

    .btn-auth-primary {
        background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 100%);
        color: white; border: none; padding: 12px;
        border-radius: 10px; font-weight: bold; width: 100%;
        margin-top: 10px; transition: 0.3s;
    }

    .btn-auth-primary:hover { opacity: 0.9; transform: translateY(-2px); }

    .switch-link { color: #3b82f6; cursor: pointer; text-decoration: none; font-weight: 600; }
    
    .fade-form { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Thông báo tài khoản bị khóa */
    .account-locked-notice {
        background-color: #fff5f5;
        border-left: 4px solid #f56565;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<!-- AUTH MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content auth-modal-content">
            <div class="row g-0">
                <div class="col-md-5 auth-left d-none d-md-flex flex-column justify-content-between">
                    <div style="position: relative; z-index: 2;">
                        <div class="mb-5 d-flex align-items-center fw-bold">
                            <span style="background: white; width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px;"></span> CLEAN TECH
                        </div>
                        <h2 class="fw-bold display-6 mb-3" id="auth-side-title">Mừng bạn trở lại!</h2>
                        <p class="text-white-50" id="auth-side-desc">Tiếp tục hành trình bảo vệ môi trường cùng công nghệ hiện đại nhất.</p>
                    </div>
                </div>

                <div class="col-md-7 auth-right">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                    
                    <!-- LOGIN FORM -->
                    <div id="login-form-container" class="fade-form">
                        <h3 class="fw-bold mb-4">Đăng nhập</h3>

                        <!-- Hiển thị thông báo nếu tài khoản bị khóa (nhận từ Session) -->
                        <?php if (isset($_SESSION['auth_status']) && $_SESSION['auth_status'] === 'locked'): ?>
                            <div class="account-locked-notice">
                                <p class="text-danger small mb-0 fw-bold">
                                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                                    Tài khoản của bạn hiện đang bị khóa.
                                </p>
                                <p class="text-muted extra-small mb-0 mt-1" style="font-size: 11px;">
                                    Vui lòng liên hệ quản trị viên để biết thêm chi tiết.
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- CHỈ SỬA ACTION Ở ĐÂY -->
                        <form action="public_entry.php?url=login" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= CsrfHelper::generateToken(); ?>">
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Email</label>
                                <input type="email" name="email" class="form-control form-control-auth" placeholder="name@mail.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Mật khẩu</label>
                                <input type="password" name="password" class="form-control form-control-auth" placeholder="••••••••" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Ghi nhớ tôi</label>
                                </div>
                                <a href="#" class="small text-decoration-none fw-bold">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="btn-auth-primary mb-4 shadow">Vào hệ thống</button>
                            <p class="text-center small text-muted">Chưa có tài khoản? <span class="switch-link" onclick="toggleAuth('signup')">Đăng ký ngay</span></p>
                        </form>
                    </div>

                    <!-- SIGNUP FORM -->
                    <div id="signup-form-container" class="fade-form" style="display: none;">
                        <h3 class="fw-bold mb-4">Tạo tài khoản</h3>
                        <!-- CHỈ SỬA ACTION Ở ĐÂY -->
                        <form action="public_entry.php?url=register" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= CsrfHelper::generateToken(); ?>">
                            <div class="mb-2">
                                <label class="small text-muted fw-bold">Họ và tên</label>
                                <input type="text" name="full_name" class="form-control form-control-auth" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="mb-2">
                                <label class="small text-muted fw-bold">Email</label>
                                <input type="email" name="email" class="form-control form-control-auth" placeholder="name@mail.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted fw-bold">Mật khẩu</label>
                                <input type="password" name="password" class="form-control form-control-auth" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn-auth-primary mb-4 shadow">Đăng ký tài khoản</button>
                            <p class="text-center small text-muted">Đã có tài khoản? <span class="switch-link" onclick="toggleAuth('login')">Đăng nhập ngay</span></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer bg-dark text-white py-5 mt-5">
    <div class="container text-center">
        <p class="mb-0">&copy; 2026 CleanTech. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function toggleAuth(type) {
    const loginForm = document.getElementById('login-form-container');
    const signupForm = document.getElementById('signup-form-container');
    const sideTitle = document.getElementById('auth-side-title');
    const sideDesc = document.getElementById('auth-side-desc');

    if (type === 'signup') {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
        sideTitle.innerText = "Tham gia ngay!";
        sideDesc.innerText = "Trở thành một phần của cộng đồng công nghệ sạch lớn nhất.";
    } else {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
        sideTitle.innerText = "Mừng bạn trở lại!";
        sideDesc.innerText = "Tiếp tục hành trình bảo vệ môi trường cùng công nghệ hiện đại nhất.";
    }
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('login_error')) {
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
        
        if (urlParams.get('tab') === 'signup') {
            toggleAuth('signup');
        }
    }
});

<?php if (isset($_SESSION['auth_status'])): ?>
    <?php if ($_SESSION['auth_status'] !== 'locked'): ?>
        Toast.fire({
            icon: '<?= $_SESSION['auth_status'] ?>',
            title: '<?= $_SESSION['auth_message'] ?>'
        });
    <?php endif; ?>
    <?php unset($_SESSION['auth_status']); unset($_SESSION['auth_message']); ?>
<?php endif; ?>
</script>