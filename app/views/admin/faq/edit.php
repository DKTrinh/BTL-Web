<?php 
require_once '../app/views/layouts/header.php'; 
?>

<style>
    .tz-sidebar { background-color: #212529; width: 100%; z-index: 1000; padding: 20px; }
    @media (min-width: 992px) { .tz-sidebar { width: 270px; min-height: 100vh; position: sticky; top: 0; padding: 20px; } }
    .sidebar-link { transition: 0.3s; border-radius: 8px; padding: 12px 15px; display: flex; align-items: center; text-decoration: none; color: #adb5bd; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; }

    .tz-header-bar { background: white; padding: 15px 20px; border-radius: 15px; border-left: 6px solid #28a745; display: flex; flex-direction: column; gap: 10px; }
    @media (min-width: 576px) { .tz-header-bar { flex-direction: row; justify-content: space-between; align-items: center; border-radius: 20px; padding: 20px 30px; } }
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    <div class="tz-sidebar shadow-lg">
        <h5 class="text-info fw-bold mb-4 text-center mt-2"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2 mt-4">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link <?= $current_tab == 'users' ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i> Quản lý Thành viên
            </a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link <?= $current_tab == 'faq' ? 'active' : '' ?>">
                <i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp
            </a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link <?= $current_tab == 'about' ? 'active' : '' ?>">
                <i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu
            </a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        <div class="tz-header-bar shadow-sm mb-4">
            <h3 class="fw-bold m-0 text-dark fs-4"><i class="fas fa-check-double me-2 text-success"></i> DUYỆT CÂU TRẢ LỜI</h3>
            <a href="public_entry.php?url=users&tab=faq" class="btn btn-outline-secondary btn-sm shadow-sm">← Quay lại</a>
        </div>

        <div class="card shadow-lg border-0" style="border-radius: 25px;">
            <div class="card-body p-3 p-md-5">
                <form action="public_entry.php?url=users&tab=faq-update" method="POST" id="faqEditForm">
                    <input type="hidden" name="f_id" value="<?= $faq['f_id'] ?>">
                    
                    <div class="mb-3">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Chủ đề</label>
                        <input type="text" name="title" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($faq['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Câu hỏi của khách</label>
                        <textarea name="question" class="form-control bg-light border-0" rows="3"><?= htmlspecialchars($faq['question']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-success text-uppercase mb-2">Câu trả lời từ TechZone</label>
                        <textarea name="answer" class="form-control border-success" rows="6" required><?= htmlspecialchars($faq['answer']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted text-uppercase mb-2">Trạng thái</label>
                        <select name="status" class="form-select border-0 bg-light">
                            <option value="pending" <?= $faq['status'] == 'pending' ? 'selected' : '' ?>>Chờ duyệt (Ẩn)</option>
                            <option value="answered" <?= $faq['status'] == 'answered' ? 'selected' : '' ?>>Đã trả lời (Công bố)</option>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let isChanged = false;
    const form = document.getElementById('faqEditForm');

    // 1. Theo dõi thay đổi
    form.querySelectorAll('input, textarea, select').forEach(el => {
        el.addEventListener('input', () => isChanged = true);
        el.addEventListener('change', () => isChanged = true);
    });

    // 2. Popup khi ấn nút Lưu
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận lưu?',
            text: "Dữ liệu sẽ được cập nhật lên hệ thống.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lưu ngay',
            cancelButtonText: 'Hủy'
        }).then((res) => {
            if (res.isConfirmed) {
                isChanged = false;
                form.submit();
            }
        });
    });

    // 3. Popup khi thoát mà chưa lưu
    document.querySelectorAll('.sidebar-link, a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (isChanged && !this.href.includes('javascript:')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Cảnh báo!',
                    text: "Thay đổi chưa được lưu sẽ bị mất. Bạn muốn thoát?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Thoát ra',
                    cancelButtonText: 'Ở lại sửa'
                }).then((res) => {
                    if (res.isConfirmed) window.location.href = this.href;
                });
            }
        });
    });
</script>
<?php require_once '../app/views/layouts/footer.php'; ?>