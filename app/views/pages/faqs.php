<div class="container my-5 py-5">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold text-info y2k-glitch-text">CÁC CÂU HỎI THƯỜNG GẶP VÀ GIẢI ĐÁP</h1>
        <p class="text-secondary small fw-bold">TRUY VẤN CƠ SỞ DỮ LIỆU GIẢI ĐÁP HỆ THỐNG CLEANTECH</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="accordion y2k-accordion mb-5" id="faqSystem">
                <?php if (isset($data['faqs']) && !empty($data['faqs'])): ?>
                    <?php foreach ($data['faqs'] as $index => $faq): ?>
                        <div class="accordion-item y2k-packet mb-3 shadow-sm">
                            <h2 class="accordion-header" id="heading-<?= $index ?>">
                                <button class="accordion-button collapsed fw-bold text-dark" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse-<?= $index ?>">
                                    <span class="y2k-status-dot me-3"></span>
                                    <span class="text-info me-2">[REQ_<?= $index + 1 ?>]</span> 
                                    <?= htmlspecialchars($faq['question']) ?>
                                </button>
                            </h2>
                            <div id="collapse-<?= $index ?>" 
                                 class="accordion-collapse collapse" 
                                 data-bs-parent="#faqSystem">
                                <div class="accordion-body y2k-terminal-text">
                                    <div class="d-flex">
                                        <i class="fas fa-chevron-right me-2 text-success"></i>
                                        <div><?= nl2br(htmlspecialchars($faq['answer'])) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="y2k-card p-5 text-center border-dashed">
                        <p class="text-muted mb-0 italic">/ Hệ thống hiện chưa có câu hỏi nào được giải nén /</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="y2k-container p-5 border-info shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <h3 class="fw-bold text-info mb-3">GỬI YÊU CẦU TRUY VẤN</h3>
                        <p class="text-secondary small leading-relaxed">
                            Bạn không tìm thấy câu trả lời? Hãy gửi câu hỏi cho hệ thống. <br>
                            Yêu cầu của bạn sẽ được chuyển đến <strong>Quản trị viên</strong> để phân tích và cập nhật.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <form id="faqRequestForm" class="y2k-form p-4 rounded bg-white shadow-sm border">
                            <div class="mb-3">
                                <label class="extra-small fw-bold text-muted text-uppercase mb-2">Chủ đề truy vấn</label>
                                <input type="text" class="form-control y2k-input" placeholder="Ví dụ: Hiệu suất lọc AIoT..." required>
                            </div>
                            <div class="mb-4">
                                <label class="extra-small fw-bold text-muted text-uppercase mb-2">Nội dung câu hỏi</label>
                                <textarea class="form-control y2k-input" rows="3" placeholder="Nhập câu hỏi của bạn tại đây..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-info w-100 fw-bold text-white py-3 rounded-pill">
                                <i class="fas fa-paper-plane me-2"></i> GỬI YÊU CẦU ĐẾN ADMIN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* STYLE Y2K BREAKTHROUGH CHO FAQs */
.y2k-accordion .accordion-item {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 15px !important;
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.y2k-packet .accordion-button {
    background: transparent;
    padding: 20px;
    font-size: 0.95rem;
    transition: 0.3s;
}

.y2k-packet .accordion-button:not(.collapsed) {
    background: rgba(13, 202, 240, 0.05);
    color: #0dcaf0 !important;
    box-shadow: none;
}

/* Dấu chấm trạng thái nhấp nháy (System dot) */
.y2k-status-dot {
    width: 10px; height: 10px; background: #27c93f;
    border-radius: 50%; display: inline-block;
    animation: blink 1.5s infinite;
}

.y2k-terminal-text {
    background: #1e1e1e;
    color: #d1d1d1;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.85rem;
    padding: 25px;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.y2k-input {
    background: #f4f6fa;
    border: 2px solid transparent;
    padding: 12px;
    border-radius: 10px;
}

.y2k-input:focus {
    border-color: #0dcaf0;
    background: white;
    box-shadow: none;
}

@keyframes blink {
    0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; }
}

.y2k-glitch-text {
    letter-spacing: -2px;
    text-shadow: 2px 2px #ff5f56, -2px -2px #27c93f;
}
</style>

<script>
document.getElementById('faqRequestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Sử dụng SweetAlert2 (đã có trong footer của bạn) để xác nhận
    Swal.fire({
        icon: 'success',
        title: 'YÊU CẦU ĐÃ GỬI!',
        text: 'Câu hỏi của bạn đã được chuyển đến Admin. Vui lòng kiểm tra lại sau khi Admin phản hồi.',
        confirmButtonColor: '#0dcaf0',
        timer: 4000
    });
    
    this.reset(); // Xóa sạch form sau khi gửi
});
</script>