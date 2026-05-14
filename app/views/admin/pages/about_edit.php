<?php 
// 1. Nạp Header từ layouts
require_once '../app/views/layouts/header.php'; 
?>

<style>
    /* Sidebar: Rộng 100% trên mobile, 270px trên desktop */
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

    /* Thanh tiêu đề Header Bar: Stack dọc trên mobile */
    .tz-header-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        border-left: 6px solid #ffc107;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    @media (min-width: 576px) {
        .tz-header-bar {
            padding: 20px 30px;
            border-radius: 20px;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    
    <div class="tz-sidebar p-3 shadow-lg">
        <h5 class="text-info fw-bold mb-4 text-center mt-2"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link">
                <i class="fas fa-users me-2"></i> Quản lý Thành viên
            </a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link">
                <i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp
            </a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link active">
                <i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu
            </a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="sidebar-link text-white-50"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        <div class="tz-header-bar shadow-sm mb-4">
            <h3 class="fw-bold m-0 text-dark fs-4 fs-md-3">
                <i class="fas fa-edit me-2 text-warning"></i>QUẢN LÝ NỘI DUNG GIỚI THIỆU
            </h3>
            <div class="text-muted small italic">Cập nhật thông tin doanh nghiệp TechZone</div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 20px;">
            <div class="card-body p-3 p-md-5">
                <form action="public_entry.php?url=admin/about-update" method="POST">
                    <?php if(!empty($contents)): ?>
                        <?php foreach($contents as $item): ?>
                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase border-bottom pb-2 d-block">
                                <i class="fas fa-bookmark me-2 text-warning"></i><?= $item['section_name'] ?>
                            </label>
                            <textarea name="content[<?= $item['page_key'] ?>]" class="form-control border-0 bg-light mt-2 p-3" rows="4" style="border-radius: 12px;"><?= htmlspecialchars($item['content_value']) ?></textarea>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-warning w-100 w-sm-auto px-5 py-3 fw-bold rounded-pill shadow-sm">
                                <i class="fas fa-save me-2"></i>LƯU THAY ĐỔI
                            </button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>