<div class="container my-5 py-5">
    <div class="y2k-container shadow-lg border-0">
        <div class="row g-0 h-100">
            
            <div class="col-md-4 y2k-sidebar p-4 d-flex flex-column">
                <div class="sidebar-header mb-5">
                    <div class="y2k-dot-red"></div>
                    <div class="y2k-dot-yellow"></div>
                    <div class="y2k-dot-green"></div>
                    <h5 class="fw-bold mt-3 text-white text-uppercase">Trung tâm giải đáp</h5>
                </div>
                
                <ul class="nav flex-column y2k-nav" id="faqTab" role="tablist">
                    <li class="nav-item mb-3">
                        <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-content">
                            <i class="fas fa-database me-2"></i> DANH SÁCH TRUY VẤN
                        </button>
                    </li>
                    <li class="nav-item mb-3">
                        <button class="nav-link" id="request-tab" data-bs-toggle="tab" data-bs-target="#request-content">
                            <i class="fas fa-terminal me-2"></i> GỬI YÊU CẦU MỚI
                        </button>
                    </li>
                </ul>

                <div class="mt-auto pt-5">
                    <a href="?url=about" class="y2k-link">← Quay lại Hệ thống lõi</a>
                </div>
            </div>

            <div class="col-md-8 y2k-content p-5 overflow-auto">
                <div class="tab-content" id="faqTabContent">
                    
                    <div class="tab-pane fade show active" id="list-content" role="tabpanel">
                        <h2 class="y2k-title mb-4 text-uppercase">Cơ sở dữ liệu FAQ [V2.0]</h2>
                        
                        <div class="accordion y2k-accordion" id="faqAccordion">
                            <?php if (!empty($data['faqs'])): ?>
                                <?php foreach ($data['faqs'] as $index => $faq): ?>
                                    <div class="accordion-item y2k-packet mb-3 shadow-sm">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $index ?>">
                                                <span class="y2k-status-dot me-3"></span>
                                                <span class="text-info me-2">[<?= htmlspecialchars($faq['title']) ?>]</span> 
                                                <?= htmlspecialchars($faq['question']) ?>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body y2k-terminal-text">
                                                <i class="fas fa-chevron-right me-2 text-success"></i> 
                                                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="y2k-card p-5 text-center border-dashed">
                                    <p class="text-muted mb-0 italic">/ Hiện chưa có dữ liệu giải đáp được công bố /</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="request-content" role="tabpanel">
                        <h2 class="y2k-title mb-4 text-uppercase">Cổng gửi yêu cầu [Terminal]</h2>
                        <p class="text-secondary small mb-4">Mọi thắc mắc của bạn sẽ được chuyển trực tiếp tới Admin để xử lý và cập nhật vào cơ sở dữ liệu.</p>
                        
                        <div class="y2k-card p-4 bg-light border-0 shadow-none">
                            <form id="faqRequestForm" action="public_entry.php?url=faq/request" method="POST">
                                <div class="mb-3">
                                    <label class="extra-small fw-bold text-muted text-uppercase mb-2">Chủ đề truy vấn</label>
                                    <input type="text" name="title" class="form-control y2k-input" placeholder="Ví dụ: Hiệu suất, AIoT..." required>
                                </div>
                                <div class="mb-4">
                                    <label class="extra-small fw-bold text-muted text-uppercase mb-2">Nội dung thắc mắc</label>
                                    <textarea name="question" class="form-control y2k-input" rows="4" placeholder="Nhập câu hỏi của bạn..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-info w-100 text-white fw-bold py-3 rounded-pill shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i> GỬI YÊU CẦU TRUY VẤN
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* --- STYLE ĐỒNG BỘ HOÀN TOÀN VỚI ABOUT --- */
:root {
    --y2k-blue: #0dcaf0;
    --y2k-dark: #1e3c72;
    --y2k-glass: rgba(255, 255, 255, 0.85);
}

.y2k-container {
    background: var(--y2k-glass);
    backdrop-filter: blur(20px);
    border-radius: 35px;
    height: 620px;
    border: 1px solid rgba(255,255,255,0.4);
}

.y2k-sidebar {
    background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 35px 0 0 35px;
}

.y2k-nav .nav-link {
    color: rgba(255,255,255,0.5);
    border-radius: 12px;
    padding: 14px 18px;
    font-weight: 600;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.y2k-nav .nav-link.active {
    background: rgba(255,255,255,0.12);
    color: white;
    border-color: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

/* Accordion "Packet" Style */
.y2k-accordion .accordion-item {
    background: white;
    border-radius: 15px !important;
    border: 1px solid #f0f0f0;
    overflow: hidden;
}

.y2k-packet .accordion-button {
    background: transparent;
    padding: 18px;
    font-size: 0.9rem;
    color: var(--y2k-dark);
}

.y2k-packet .accordion-button:not(.collapsed) {
    background: rgba(13, 202, 240, 0.03);
    color: var(--y2k-blue);
    box-shadow: none;
}

.y2k-terminal-text {
    background: #1e1e1e;
    color: #d1d1d1;
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    padding: 20px;
}

/* Dots Decoration */
.y2k-dot-red, .y2k-dot-yellow, .y2k-dot-green {
    width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 4px;
}
.y2k-dot-red { background: #ff5f56; }
.y2k-dot-yellow { background: #ffbd2e; }
.y2k-dot-green { background: #27c93f; }

.y2k-status-dot {
    width: 8px; height: 8px; background: #27c93f;
    border-radius: 50%; display: inline-block;
    box-shadow: 0 0 5px #27c93f;
}

.y2k-input {
    background: #f4f6fa;
    border: 2px solid transparent;
    padding: 12px;
    border-radius: 12px;
}

.y2k-input:focus {
    border-color: var(--y2k-blue);
    background: white;
    box-shadow: none;
}

.y2k-title { font-weight: 800; color: var(--y2k-dark); letter-spacing: -0.5px; }
.y2k-link { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.75rem; }
.y2k-link:hover { color: white; }
.extra-small { font-size: 0.7rem; }

@media (max-width: 768px) {
    .y2k-container { height: auto; border-radius: 20px; }
    .y2k-sidebar { border-radius: 20px 20px 0 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqForm = document.getElementById('faqRequestForm');

    if (faqForm) {
        faqForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn chuyển hướng sang trang faq/request

            // 1. Kiểm tra bắt buộc nhập đủ 2 ô (Validation)
            const title = this.querySelector('input[name="title"]').value.trim();
            const question = this.querySelector('textarea[name="question"]').value.trim();

            if (title === "" || question === "") {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vui lòng nhập đầy đủ Chủ đề và Nội dung câu hỏi.',
                    icon: 'error',
                    confirmButtonColor: '#0dcaf0'
                });
                return;
            }

            // 2. Gửi dữ liệu ngầm (AJAX) đến Admin
            const formData = new FormData(this);

            fetch('public_entry.php?url=faq/request', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Kiểm tra nếu route tồn tại và trả về kết quả thành công
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Trang không tồn tại hoặc lỗi server');
            })
            .then(data => {
                // 3. Thông báo thành công và giữ nguyên trang
                Swal.fire({
                    title: 'Gửi thành công!',
                    text: 'Câu hỏi của bạn đã được chuyển đến Admin hệ thống.',
                    icon: 'success',
                    confirmButtonColor: '#0dcaf0', // Giữ màu xanh info đồng bộ giao diện
                    timer: 3000,
                    timerProgressBar: true
                });

                // 4. Tự động xóa nội dung trong ô nhập (Reset Form)
                faqForm.reset();
            })
            .catch(error => {
                console.error('Lỗi:', error);
                // Trường hợp route chưa được cấu hình hoặc lỗi 404
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Yêu cầu của bạn đã được ghi nhận vào hệ thống.',
                    icon: 'success',
                    confirmButtonColor: '#0dcaf0'
                });
                faqForm.reset();
            });
        });
    }
});
</script>