<?php 
// 1. Nạp Header từ layouts
require_once '../app/views/layouts/header.php'; 
?>

<style>
    /* Sidebar Responsive */
    .tz-sidebar { background-color: #212529; width: 100%; z-index: 1000; padding: 20px; }
    @media (min-width: 992px) { .tz-sidebar { width: 270px; min-height: 100vh; position: sticky; top: 0; padding: 20px; } }

    .sidebar-link { transition: all 0.3s ease; border-radius: 8px; font-weight: 500; display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #adb5bd; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); color: #1abc9c !important; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    
    /* Header Bar chuẩn Hình 3 */
    .tz-header-bar { background: white; padding: 15px 20px; border-radius: 15px; border-left: 6px solid #28a745; display: flex; flex-direction: column; gap: 15px; }
    @media (min-width: 576px) { .tz-header-bar { padding: 20px 30px; border-radius: 20px; flex-direction: row; justify-content: space-between; align-items: center; } }
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
            <h3 class="fw-bold m-0 text-dark fs-4"><i class="fas fa-question-circle me-2 text-success"></i> Hệ thống Quản lý FAQ</h3>
            <button class="btn btn-primary fw-bold px-4 rounded-3 w-100 w-sm-auto shadow-sm">+ Thêm câu hỏi</button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center text-nowrap">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3">Mã REQ</th>
                            <th>Chủ đề</th>
                            <th>Câu hỏi</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php if(!empty($faqs)): foreach($faqs as $f): ?>
                        <tr>
                            <td class="fw-bold">#<?= $f['f_id'] ?></td>
                            <td><span class="badge bg-info text-dark rounded-pill px-3"><?= htmlspecialchars($f['title']) ?></span></td>
                            <td class="text-start small"><?= htmlspecialchars(substr($f['question'], 0, 60)) ?>...</td>
                            <td><span class="badge <?= $f['status'] == 'answered' ? 'bg-success' : 'bg-warning' ?> rounded-pill"><?= $f['status'] ?></span></td>
                            <td>
                                <a href="public_entry.php?url=users&tab=faq-edit&id=<?= $f['f_id'] ?>" class="btn btn-sm btn-warning fw-bold px-3 shadow-sm"><i class="fas fa-edit"></i> Duyệt</a>
                                <button class="btn btn-sm btn-danger px-2 shadow-sm" onclick="confirmDelete(<?= $f['f_id'] ?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="py-5 text-muted italic">Chưa có dữ liệu câu hỏi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once '../app/views/layouts/footer.php'; ?>