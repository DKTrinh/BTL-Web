<?php 
// Nạp Header từ layouts
require_once '../app/views/layouts/header.php'; 
?>

<style>
    /* 1. Tối ưu Sidebar: Rộng toàn màn hình trên mobile, cố định trên desktop */
    .tz-sidebar { 
        background-color: #212529; 
        width: 100%; 
        z-index: 1000;
    }
    
    @media (min-width: 992px) {
        .tz-sidebar { 
            width: 270px; 
            min-height: 100vh; 
            position: sticky; 
            top: 0; 
        }
    }

    .sidebar-link { transition: all 0.3s ease; border-radius: 8px; font-weight: 500; display: flex; align-items: center; padding: 12px 15px; color: #adb5bd; text-decoration: none; }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); color: #1abc9c !important; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }

    /* 2. Tối ưu Header Bar: Tự động xuống dòng trên màn hình nhỏ */
    .tz-header-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        border-left: 6px solid #007bff;
        display: flex;
        flex-direction: column; /* Mặc định dọc trên mobile */
        gap: 15px;
    }

    @media (min-width: 576px) {
        .tz-header-bar {
            padding: 20px 30px;
            border-radius: 20px;
            flex-direction: row; /* Ngang trên tablet/desktop */
            justify-content: space-between;
            align-items: center;
        }
    }

    /* 3. Tối ưu bảng dữ liệu: Tránh bị tràn màn hình */
    .table-responsive {
        border-radius: 15px;
    }
    
    .card.rounded-4 {
        border-radius: 1rem !important;
    }
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    
    <div class="tz-sidebar p-3 shadow-lg">
        <h5 class="text-info fw-bold mb-4 text-center mt-2"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-1">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link">
                <i class="fas fa-users me-2"></i> Quản lý Thành viên
            </a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link active">
                <i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp
            </a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link">
                <i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu
            </a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        
        <div class="tz-header-bar shadow-sm mb-4">
            <h3 class="fw-bold m-0 text-dark fs-4 fs-md-3">
                <i class="fas fa-question-circle me-2 text-primary"></i>Hệ thống Quản lý FAQ
            </h3>
            <button class="btn btn-primary fw-bold px-4 rounded-3 shadow-sm w-100 w-sm-auto">
                <i class="fas fa-plus-circle me-2"></i>Thêm câu hỏi
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3 text-nowrap">Mã REQ</th>
                            <th class="text-nowrap">Chủ đề</th>
                            <th>Câu hỏi</th>
                            <th class="text-nowrap">Trạng thái</th>
                            <th class="text-nowrap">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($faqs)): ?>
                            <?php foreach($faqs as $f): ?>
                            <tr>
                                <td class="fw-bold">#<?= $f['f_id'] ?></td>
                                <td><span class="badge bg-info text-dark rounded-pill px-3"><?= htmlspecialchars($f['title']) ?></span></td>
                                <td class="text-start small" style="min-width: 200px;"><?= htmlspecialchars(substr($f['question'], 0, 60)) ?>...</td>
                                <td>
                                    <span class="badge <?= $f['status'] == 'answered' ? 'bg-success' : 'bg-warning' ?> rounded-pill px-3">
                                        <?= $f['status'] == 'answered' ? 'Đã công bố' : 'Chờ duyệt' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="public_entry.php?url=users&tab=faq-edit&id=<?= $f['f_id'] ?>" class="btn btn-sm btn-warning fw-bold px-3 shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="public_entry.php?url=users&tab=faq-delete&id=<?= $f['f_id'] ?>" class="btn btn-sm btn-danger px-3 shadow-sm" onclick="return confirm('Xóa câu hỏi này?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="py-5 text-muted italic">Chưa có dữ liệu câu hỏi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
// Nạp Footer từ layouts
require_once '../app/views/layouts/footer.php'; 
?>