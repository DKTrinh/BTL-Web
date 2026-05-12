<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="y2k-card p-5 shadow-lg border-0" style="border-radius: 30px; background: #ffffff;">
                <h3 class="fw-bold text-primary mb-4 text-uppercase">Biên tập & Công bố FAQ</h3>
                
                <form action="public_entry.php?url=admin/faq/update" method="POST">
                    <input type="hidden" name="f_id" value="<?= $faq['f_id'] ?>">
                    <input type="hidden" name="status" value="answered">

                    <div class="mb-4 p-3 bg-light rounded-4 border-start border-info border-4">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Chủ đề (Có thể sửa lại)</label>
                        <input type="text" name="title" class="form-control border-0 bg-transparent fw-bold" value="<?= htmlspecialchars($faq['title']) ?>">
                        
                        <label class="small fw-bold text-muted text-uppercase mt-3 mb-2">Câu hỏi của khách</label>
                        <textarea name="question" class="form-control border-0 bg-transparent small" rows="2"><?= htmlspecialchars($faq['question']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-dark mb-3">Câu trả lời chính thức (Bắt buộc để duyệt)</label>
                        <textarea name="answer" class="form-control p-4 shadow-sm" style="border-radius: 20px; background: #fdfdfd;" 
                                  rows="6" placeholder="Nhập câu trả lời để hệ thống tự động công bố..." required><?= htmlspecialchars($faq['answer'] ?? '') ?></textarea>
                        <div class="form-text mt-2 italic small text-info">
                            <i class="bi bi-info-circle me-1"></i> Khi bạn nhấn nút dưới đây, câu hỏi sẽ xuất hiện ngay lập tức tại mục FAQ của người dùng.
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-pill shadow">
                            <i class="bi bi-check-circle me-2"></i> DUYỆT & CÔNG BỐ
                        </button>
                        <a href="public_entry.php?url=users" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>