<?php
// app/views/pages/contact.php
// Đảm bảo file này được gọi từ layout chính có chứa <head> và các thư viện cần thiết
 require_once '../app/views/layouts/header.php'; 
?>

<!-- Thêm FontAwesome nếu chưa có trong layout chính -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

<!-- Contact Hero -->
<section class="contact-hero">
    <div class="container">
        <h1>Liên hệ với CleanTech</h1>
        <p>
            Chúng tôi luôn sẵn sàng hỗ trợ khách hàng về sản phẩm,
            giải pháp công nghệ và các dịch vụ kỹ thuật.
        </p>
    </div>
</section>

<!-- Main Content -->
<div class="container">

    <div class="contact-grid">

        <!-- LEFT -->
        <div class="info-card">

            <h2>
                <i class="fas fa-building"></i>
                Thông tin liên hệ
            </h2>

            <div class="contact-detail-item">
                <i class="fas fa-phone-alt"></i>

                <div>
                    <h3>Tổng đài hỗ trợ</h3>

                    <p>
                        <strong>1900 6888</strong>
                    </p>

                    <p>Email: support@cleantech.vn</p>

                    <p>Thời gian: 7:30 - 22:00</p>
                </div>
            </div>

            <div class="contact-detail-item">
                <i class="fas fa-location-dot"></i>

                <div>
                    <h3>Văn phòng chính</h3>

                    <p>
                        123 Nguyễn Trãi, Quận 1,
                        TP.Hồ Chí Minh
                    </p>
                </div>
            </div>

            <h3 class="store-title">
                <i class="fas fa-store"></i>
                Chi nhánh
            </h3>

            <div class="store-list">

                <div class="store-item">
                    <h4>CleanTech Hồ Chí Minh</h4>

                    <p>
                        <i class="fas fa-map-pin"></i>
                        Quận 1, TP.HCM
                    </p>

                    <p>
                        <i class="fas fa-phone"></i>
                        028 1234 5678
                    </p>
                </div>

                <div class="store-item">
                    <h4>CleanTech Hà Nội</h4>

                    <p>
                        <i class="fas fa-map-pin"></i>
                        Cầu Giấy, Hà Nội
                    </p>

                    <p>
                        <i class="fas fa-phone"></i>
                        024 1234 5678
                    </p>
                </div>

                <div class="store-item">
                    <h4>CleanTech Đà Nẵng</h4>

                    <p>
                        <i class="fas fa-map-pin"></i>
                        Hải Châu, Đà Nẵng
                    </p>

                    <p>
                        <i class="fas fa-phone"></i>
                        0236 123 456
                    </p>
                </div>

            </div>
        </div>

        <!-- RIGHT -->
        <div class="form-card">

            <h2>
                <i class="fas fa-envelope"></i>
                Gửi liên hệ
            </h2>

            <p class="form-desc">
                Vui lòng để lại thông tin.
                Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
            </p>

            <!-- Success -->
            <div id="alertSuccess" class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Gửi liên hệ thành công!
            </div>

            <!-- Error -->
            <div id="alertError" class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMessage"></span>
            </div>

            <!-- FORM -->
            <form id="contactForm">
                <!-- CSRF token (nếu backend yêu cầu, cần render từ PHP) -->
                <!-- <input type="hidden" name="csrf_token" value="<?php // echo $_SESSION['csrf_token']; ?>"> -->

                <div class="form-group">
                    <label>
                        Họ và tên
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="fullname"
                        class="form-control"
                        placeholder="Nhập họ tên"
                    >
                </div>

                <div class="form-group">
                    <label>
                        Email
                        <span class="required">*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        class="form-control"
                        placeholder="example@gmail.com"
                    >
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>

                    <input
                        type="tel"
                        id="phone"
                        class="form-control"
                        placeholder="0xxx xxx xxx"
                    >
                </div>

                <div class="form-group">
                    <label>Tiêu đề</label>

                    <input
                        type="text"
                        id="subject"
                        class="form-control"
                        placeholder="Tiêu đề liên hệ"
                    >
                </div>

                <div class="form-group">
                    <label>
                        Nội dung
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="message"
                        class="form-control"
                        placeholder="Nhập nội dung liên hệ..."
                    ></textarea>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    Gửi liên hệ
                </button>

            </form>
        </div>
    </div>

    <!-- MAP -->
    <div class="map-section">

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.456097167203!2d106.70175527570395!3d10.77653005920554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3b4627d8d1%3A0x79c1c3cfef95c0d5!2zTmfDtGkgVHLhuqFpLCBC4bq_biBUaMOgbmgsIFF14bqtbiAxLCBI4buTIENow60gTWluaA!5e0!3m2!1svi!2s!4v1711111111111"
            loading="lazy"
            allowfullscreen=""
        ></iframe>

    </div>

</div>

<!-- CSS -->
<style>

.contact-hero{
    background: linear-gradient(135deg,#0b2b44,#1e6f5c);
    padding:70px 0;
    color:white;
    text-align:center;
    margin-bottom:50px;
}

.contact-hero h1{
    font-size:48px;
    font-weight:800;
    margin-bottom:15px;
}

.contact-hero p{
    font-size:18px;
    opacity:.9;
}

.contact-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
    margin-bottom:50px;
}

.info-card,
.form-card{
    background:white;
    border-radius:24px;
    padding:32px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.info-card h2,
.form-card h2{
    font-size:28px;
    margin-bottom:24px;
    color:#0b2b44;
}

.contact-detail-item{
    display:flex;
    gap:18px;
    margin-bottom:28px;
    border-bottom:1px solid #eee;
    padding-bottom:20px;
}

.contact-detail-item i{
    font-size:24px;
    color:#1e6f5c;
}

.contact-detail-item h3{
    margin-bottom:8px;
}

.store-title{
    margin-bottom:20px;
    color:#0b2b44;
}

.store-list{
    display:grid;
    gap:20px;
}

.store-item{
    background:#f8fafc;
    padding:20px;
    border-radius:16px;
    transition:.2s;
}

.store-item:hover{
    transform:translateY(-3px);
}

.store-item h4{
    margin-bottom:10px;
    color:#0b2b44;
}

.store-item p{
    margin:6px 0;
    color:#5f7f9e;
}

.form-desc{
    margin-bottom:24px;
    color:#666;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.required{
    color:red;
}

.form-control{
    width:100%;
    padding:14px 16px;
    border:1px solid #ddd;
    border-radius:12px;
    font-size:15px;
}

.form-control:focus{
    outline:none;
    border-color:#1e6f5c;
}

textarea.form-control{
    min-height:120px;
    resize:vertical;
}

.btn-submit{
    width:100%;
    border:none;
    background:#1e6f5c;
    color:white;
    padding:14px;
    border-radius:40px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.btn-submit:disabled{
    background:#95a5a6;
    cursor:not-allowed;
}

.btn-submit:hover:not(:disabled){
    background:#0e5545;
}

.alert{
    display:none;
    padding:16px;
    border-radius:12px;
    margin-bottom:20px;
}

.alert.show{
    display:block;
}

.alert-success{
    background:#d4edda;
    color:#155724;
}

.alert-danger{
    background:#f8d7da;
    color:#721c24;
}

.map-section{
    margin-bottom:50px;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.map-section iframe{
    width:100%;
    height:400px;
    border:0;
}

@media(max-width:768px){

    .contact-grid{
        grid-template-columns:1fr;
    }

    .contact-hero h1{
        font-size:32px;
    }

}

</style>

<!-- JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertSuccess = document.getElementById('alertSuccess');
    const alertError = document.getElementById('alertError');
    const errorMessageSpan = document.getElementById('errorMessage');

    // Helper ẩn alert
    function hideAlerts() {
        alertSuccess.classList.remove('show');
        alertError.classList.remove('show');
    }

    // Helper hiển thị lỗi
    function showError(message) {
        errorMessageSpan.textContent = message;
        alertError.classList.add('show');
        setTimeout(() => {
            alertError.classList.remove('show');
        }, 5000);
    }

    // Helper hiển thị thành công
    function showSuccess() {
        alertSuccess.classList.add('show');
        setTimeout(() => {
            alertSuccess.classList.remove('show');
        }, 5000);
    }

    // Validate số điện thoại (cơ bản)
    function isValidPhone(phone) {
        if (!phone) return true;
        const phoneRegex = /^(0|\+84)[0-9]{9,10}$/;
        return phoneRegex.test(phone);
    }

    // Xây dựng đường dẫn API dựa trên cấu trúc thư mục thực tế
    // Ví dụ: http://localhost/BTL-Web-pages/public/public_entry.php
    function getApiUrl() {
        // Lấy đường dẫn gốc từ window.location, ví dụ: http://localhost/BTL-Web-pages/public/
        const base = window.location.origin + window.location.pathname.split('/').slice(0, -1).join('/');
        return `${base}/public_entry.php?url=contact/save`;
    }

    // Xử lý submit
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        hideAlerts();

        const fullname = document.getElementById('fullname').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();

        if (fullname === '') {
            showError('Vui lòng nhập họ tên');
            return;
        }
        if (email === '') {
            showError('Vui lòng nhập email');
            return;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError('Email không đúng định dạng');
            return;
        }
        if (phone !== '' && !isValidPhone(phone)) {
            showError('Số điện thoại không hợp lệ (định dạng 0xxxxxxxxx hoặc +84xxxxxxxxx)');
            return;
        }
        if (message === '') {
            showError('Vui lòng nhập nội dung');
            return;
        }

        submitBtn.disabled = true;
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Đang gửi...';

        try {
            const apiUrl = getApiUrl();
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ fullname, email, phone, subject, message })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server error:', response.status, errorText);
                throw new Error(`Lỗi server (${response.status})`);
            }

            const contentType = response.headers.get('content-type');
            let result;
            if (contentType && contentType.includes('application/json')) {
                result = await response.json();
            } else {
                const text = await response.text();
                console.error('Response not JSON:', text);
                throw new Error('Server trả về định dạng không hợp lệ');
            }

            if (result.success) {
                showSuccess();
                form.reset();
            } else {
                showError(result.message || 'Gửi thất bại, vui lòng thử lại');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showError('Không thể kết nối server hoặc có lỗi xảy ra. Vui lòng thử lại sau.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
});
</script>


<?php require_once '../app/views/layouts/footer.php'; ?>