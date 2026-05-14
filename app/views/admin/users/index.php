<?php 
// Mặc định tab là users nếu không có tham số truyền vào
$current_tab = $_GET['tab'] ?? 'users'; 
?>
<style>
    /* 1. Sidebar: Trên mobile là khối trên cùng, trên desktop là thanh bên trái */
    .tz-sidebar { 
        background-color: #212529; 
        width: 100%; 
        z-index: 1000;
        padding: 20px;
    }
    
    @media (min-width: 992px) {
        .tz-sidebar { 
            width: 270px; 
            min-height: 100vh; 
            position: sticky; 
            top: 0; 
            padding: 15px;
        }
    }

    /* 2. Link Sidebar: Màu xanh lá đậm khi Active đúng như hình */
    .sidebar-link { 
        transition: all 0.3s ease; 
        border-radius: 8px; 
        font-weight: 500; 
        display: flex; 
        align-items: center; 
        padding: 12px 15px; 
        text-decoration: none; 
        color: #adb5bd;
    }
    .sidebar-link:hover { background-color: rgba(255,255,255,0.1); color: #1abc9c !important; }
    .sidebar-link.active { 
        background-color: #1e6f5c !important; /* Màu xanh đặc trưng trong ảnh */
        color: white !important; 
        font-weight: 700; 
    }
    
    /* 3. Thanh tiêu đề Header Bar (Header trắng bo góc) */
    .tz-header-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 15px;
        border-left: 6px solid #007bff; /* Viền xanh cho tab Users */
        display: flex;
        flex-direction: column;
        gap: 15px;
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
    
    .faq-border { border-left-color: #28a745 !important; } /* Viền xanh lá cho tab FAQ */
</style>

<div class="d-flex flex-column flex-lg-row" style="background-color: #f4f6fa; min-height: 100vh;">
    
    <div class="tz-sidebar shadow-lg">
        <h5 class="fw-bold mb-4 text-center text-info" style="letter-spacing: 1px;">
            <i class="fas fa-microchip me-2"></i> TECHZONE
        </h5>
        <div class="nav flex-column gap-2 mt-2">
            <a href="public_entry.php?url=users&tab=users" class="sidebar-link <?= $current_tab == 'users' ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i> Quản lý Thành viên
            </a>
            <a href="public_entry.php?url=users&tab=faq" class="sidebar-link <?= $current_tab == 'faq' ? 'active' : '' ?>">
                <i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp
            </a>
            <a href="public_entry.php?url=users&tab=about" class="sidebar-link <?= $current_tab == 'about' ? 'active' : '' ?>">
                <i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu
            </a>
            <hr class="text-white-50">
            <a href="#" class="sidebar-link text-white-50 small"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="sidebar-link text-white-50 small"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-3 p-md-4">
        
        <?php if($current_tab == 'users'): ?>
            <div class="tz-header-bar shadow-sm mb-4">
                <h3 class="fw-bold text-dark m-0 fs-4">
                    <i class="fas fa-users-cog me-2 text-primary"></i> Quản lý Thành viên
                </h3>
                <button class="btn btn-primary fw-bold px-4 rounded-3 w-100 w-sm-auto shadow-sm">
                    <i class="fas fa-user-plus me-2"></i> Thêm thành viên
                </button>
            </div>
            
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-nowrap">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="ps-4 py-3">User</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if(!empty($users)): foreach($users as $u): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-secondary me-2 shadow-sm" style="width:35px; height:35px;"></div>
                                        <div><div class="fw-bold small"><?= htmlspecialchars($u['fullname']) ?></div><div class="text-muted small">ID: #<?= $u['id'] ?></div></div>
                                    </div>
                                </td>
                                <td class="small"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="small"><?= htmlspecialchars($u['phone'] ?? '---') ?></td>
                                <td><span class="badge bg-success rounded-pill px-3 py-2 small">Hoạt động</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info text-dark fw-bold px-3 shadow-sm"><i class="fas fa-eye"></i> Sửa</button>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php elseif($current_tab == 'faq'): ?>
            <div class="tz-header-bar faq-border shadow-sm mb-4">
                <h3 class="fw-bold text-dark m-0 fs-4">
                    <i class="fas fa-question-circle me-2 text-success"></i> Hệ thống Quản lý FAQ
                </h3>
                <button class="btn btn-primary fw-bold px-4 rounded-3 w-100 w-sm-auto shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i> Thêm câu hỏi
                </button>
            </div>
            <?php endif; ?>

    </div>
</div>