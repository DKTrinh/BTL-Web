document.addEventListener('DOMContentLoaded', function() {
    // Client-side validation cho Form đăng ký (như đề bài yêu cầu kiểm tra dữ liệu đầu vào JS)
    const authForm = document.getElementById('authForm');
    if (authForm) {
        authForm.addEventListener('submit', function(e) {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            if (pass.length < 6 || pass !== confirm) {
                alert("Vui lòng kiểm tra lại mật khẩu (tối thiểu 6 ký tự) và xác nhận mật khẩu!");
                e.preventDefault(); // Ngăn submit form về server
            }
        });
    }
});