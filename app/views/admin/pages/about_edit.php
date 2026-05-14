<?php require_once '../app/views/layouts/header.php'; ?>
<style>
    .tz-sidebar { background-color: #212529; width: 100%; z-index: 1000; padding: 20px; }
    @media (min-width: 992px) { .tz-sidebar { width: 270px; min-height: 100vh; position: sticky; top: 0; padding: 20px; } }
    .sidebar-link { transition: 0.3s; border-radius: 8px; padding: 12px 15px; display: flex; align-items: center; text-decoration: none; color: #adb5bd; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; }
    .tz-header-bar { background: white; padding: 20px; border-radius: 20px; border-left: 6px solid #ffc107; display: flex; flex-direction: column; gap: 10px; }
    @media (min-width: 576px) { .tz-header-bar { flex-direction: row; justify-content: space-between; align-items: center; } }
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    <div class="tz-sidebar p-3 shadow-lg">
        <h5 class="text-info fw-bold mb-4 text-center mt-2"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2 mt-4">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link"><i class="fas fa-users me-2"></i> Quản lý Thành viên</a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link"><i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp</a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link active"><i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu</a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        <div class="tz-header-bar shadow-sm mb-4">
            <h3 class="fw-bold m-0 text-dark fs-4"><i class="fas fa-edit me-2 text-warning"></i>QUẢN LÝ NỘI DUNG GIỚI THIỆU</h3>
            <div class="text-muted small italic">Cập nhật thông tin doanh nghiệp TechZone</div>
        </div>
        <div class="card shadow-sm border-0" style="border-radius: 20px;">
            <div class="card-body p-3 p-md-5">
                <form action="public_entry.php?url=admin/about-update" method="POST" id="aboutForm">
                    <?php foreach($contents as $item): ?>
                    <div class="mb-4">
                        <label class="fw-bold text-muted small text-uppercase border-bottom pb-2 d-block"><i class="fas fa-bookmark me-2 text-warning"></i><?= $item['section_name'] ?></label>
                        <textarea name="content[<?= $item['page_key'] ?>]" class="form-control border-0 bg-light mt-2 p-3" rows="4" style="border-radius: 12px;"><?= htmlspecialchars($item['content_value']) ?></textarea>
                    </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill shadow-sm">LƯU THAY ĐỔI</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let contentChanged = false;
    const form = document.getElementById('aboutForm');
    form.querySelectorAll('textarea').forEach(area => area.addEventListener('input', () => contentChanged = true));

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({ title: 'Lưu thay đổi?', text: "Bạn có chắc chắn muốn cập nhật không?", icon: 'info', showCancelButton: true, confirmButtonColor: '#ffc107', confirmButtonText: 'Đồng ý' }).then(res => { if(res.isConfirmed) { contentChanged = false; form.submit(); } });
    });

    document.querySelectorAll('.sidebar-link, a').forEach(link => {
        link.addEventListener('click', function(e) { if(contentChanged) { e.preventDefault(); Swal.fire({ title: 'Cảnh báo!', text: "Thay đổi chưa lưu sẽ bị mất.", icon: 'warning', showCancelButton: true, confirmButtonText: 'Thoát ra' }).then(res => { if(res.isConfirmed) window.location.href = this.href; }); } });
    });
    const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('status') === 'success') {
    Swal.fire({
        title: 'Đã cập nhật!',
        text: 'Nội dung giới thiệu đã được lưu lại.',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    });
}
</script>
<?php require_once '../app/views/layouts/footer.php'; ?>