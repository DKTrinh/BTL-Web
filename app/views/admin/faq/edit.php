<?php 
// Nạp Header từ layouts
require_once '../app/views/layouts/header.php'; 
?>

<style>
    /* Tái sử dụng CSS Responsive cho Sidebar và Header */
    .tz-sidebar { background-color: #212529; width: 100%; z-index: 1000; }
    @media (min-width: 992px) { .tz-sidebar { width: 270px; min-height: 100vh; position: sticky; top: 0; } }

    .sidebar-link { transition: all 0.3s ease; border-radius: 8px; font-weight: 500; display: flex; align-items: center; padding: 12px 15px; color: #adb5bd; text-decoration: none; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; }

    .tz-header-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        border-left: 6px solid #28a745; /* Màu xanh lá cho FAQ */
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    @media (min-width: 576px) { .tz-header-bar { padding: 20px 30px; border-radius: 20px; flex-direction: row; justify-content: space-between; align-items: center; } }
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    
    <div class="tz-sidebar p-3 shadow-lg">
        <h5 class="text-info fw-bold mb-4 text-center mt-2"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link">
                <i class="fas fa-users me-2"></i> Quản lý Thành viên
            </a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link active">
                <i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp
            </a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link">
                <i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu
            </a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        <div class="tz-header-bar shadow-sm mb-4">
            <h3 class="fw-bold m-0 text-dark fs-4 fs-md-3">
                <i class="fas fa-check-double me-2 text-success"></i>DUYỆT CÂU TRẢ LỜI
            </h3>
            <a href="public_entry.php?url=users&tab=faq" class="btn btn-outline-secondary btn-sm shadow-sm">← Quay lại</a>
        </div>

        <div class="card shadow-lg border-0" style="border-radius: 25px;">
            <div class="card-body p-3 p-md-5">
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
                        <label class="small fw-bold text-success text-uppercase mb-2">Câu trả lời từ TechZone</label>
                        <textarea name="answer" class="form-control border-success" rows="6" placeholder="Nhập câu trả lời..." required><?= htmlspecialchars($faq['answer']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Trạng thái</label>
                        <select name="status" class="form-select border-0 bg-light">
                            <option value="pending" <?= $faq['status'] == 'pending' ? 'selected' : '' ?>>Chờ duyệt (Ẩn)</option>
                            <option value="answered" <?= $faq['status'] == 'answered' ? 'selected' : '' ?>>Đã trả lời (Hiển thị)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow">
                        <i class="fas fa-save me-2"></i> LƯU VÀ CÔNG BỐ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>