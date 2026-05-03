document.addEventListener('DOMContentLoaded', function() {
    // Các phần tử giao diện
    const loginSection = document.getElementById('login-section');
    const registerSection = document.getElementById('register-section');
    const welcomeTitle = document.getElementById('welcome-title');
    const welcomeText = document.getElementById('welcome-text');

    // Nút trigger chuyển đổi
    const toRegisterBtn = document.getElementById('to-register');
    const toLoginBtn = document.getElementById('to-login');

    // Sự kiện: Bấm Sign up -> Hiện Register
    if (toRegisterBtn) {
        toRegisterBtn.addEventListener('click', function() {
            loginSection.classList.add('d-none');
            registerSection.classList.remove('d-none');
            welcomeTitle.innerHTML = "Join our<br>community!";
            welcomeText.innerText = "Create an account to start managing your environmental solutions.";
        });
    }

    // Sự kiện: Bấm Back to Login -> Hiện Login
    if (toLoginBtn) {
        toLoginBtn.addEventListener('click', function() {
            registerSection.classList.add('d-none');
            loginSection.classList.remove('d-none');
            welcomeTitle.innerHTML = "Hello,<br>welcome!";
            welcomeText.innerText = "Advanced emission control systems for environmental sustainability.";
        });
    }

    // Logic Validation mật khẩu (Giữ nguyên)
    const authForm = document.getElementById('authForm');
    if (authForm) {
        authForm.addEventListener('submit', function(e) {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            if (pass.length < 6 || pass !== confirm) {
                alert("Please check your password and confirmation!");
                e.preventDefault();
            }
        });
    }
});