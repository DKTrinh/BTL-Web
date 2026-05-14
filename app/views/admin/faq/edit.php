<?php 
// Nạp Header từ layouts
require_once '../app/views/layouts/header.php'; 
?>

<div class="container py-5">
    <div class="card shadow-lg border-0" style="border-radius: 25px;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0" style="color: #1e3a3a;">BIÊN TẬP & DUYỆT CÂU TRẢ LỜI</h5>
                <a href="public_entry.php?url=users&tab=faq" class="text-decoration-none small text-muted">← Quay lại danh sách</a>
            </div>

            <form action="public_entry.php?url=users&tab=faq-update" method="POST">
                <input type="hidden" name="f_id" value="<?= $faq['f_id'] ?>">
                
                <div class="mb-3">
                    <label class="small fw-bold text-muted text-uppercase mb-2">Chủ đề</label>
                    <input type="text" name="title" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($faq['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted text-uppercase mb-2">Nội dung câu hỏi của khách</label>
                    <textarea name="question" class="form-control bg-light border-0" rows="3"><?= htmlspecialchars($faq['question']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-success text-uppercase mb-2">Câu trả lời chính thức từ TechZone</label>
                    <textarea name="answer" class="form-control border-success" rows="6" placeholder="Nhập câu trả lời tại đây..." required><?= htmlspecialchars($faq['answer']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="small fw-bold text-muted text-uppercase mb-2">Trạng thái hiển thị</label>
                    <select name="status" class="form-select border-0 bg-light">
                        <option value="pending" <?= $faq['status'] == 'pending' ? 'selected' : '' ?>>Đang chờ duyệt (Ẩn)</option>
                        <option value="answered" <?= $faq['status'] == 'answered' ? 'selected' : '' ?>>Đã trả lời (Hiển thị lên FAQ)</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow">
                        <i class="fas fa-save me-2"></i> LƯU VÀ CÔNG BỐ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
// Nạp Footer từ layouts
require_once '../app/views/layouts/footer.php'; 
?>