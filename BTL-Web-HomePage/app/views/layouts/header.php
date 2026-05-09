<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $_SESSION['user_role'] ?? '';
$userName = $_SESSION['user_name'] ?? 'Người dùng';
$defaultAvatar = 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg';
$userAvatar = !empty($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : $defaultAvatar;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --primary-blue: #2563eb; --bg-light-blue: #f0f7ff; --dark-bg: #111827; }
        body { font-family: 'Inter', system-ui, sans-serif; color: #333; }
        .navbar-brand { color: var(--dark-bg); font-weight: 800; font-size: 1.5rem; }
        .navbar-brand i { color: var(--primary-blue); }
        .nav-link { font-size: 0.95rem; color: #555; margin: 0 5px; font-weight: 600; transition: color 0.2s;}
        .nav-link:hover { color: var(--primary-blue); }
        .btn-primary-custom { background-color: var(--primary-blue); color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; }
        .btn-primary-custom:hover { background-color: #1d4ed8; color: white; }
        .search-bar .form-control { border-radius: 20px 0 0 20px; border-right: none; }
        .search-bar .btn { border-radius: 0 20px 20px 0; border-left: none; border-color: #dee2e6; }
        .search-bar .form-control:focus { box-shadow: none; border-color: #dee2e6; }
        .dropdown-menu-custom { border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .dropdown-item { font-weight: 500; font-size: 0.9rem; padding: 8px 20px; }
        .dropdown-item:hover { background-color: var(--bg-light-blue); color: var(--primary-blue); }
        .modal-backdrop.show { opacity: 0.8 !important; background: rgba(42, 82, 152, 0.6) !important; backdrop-filter: blur(8px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white sticky-top py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="public_entry.php?url=home">
            <i class="bi bi-leaf-fill me-2"></i> CleanTech
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex ms-lg-4 me-auto search-bar" action="public_entry.php" method="GET" style="max-width: 280px; width: 100%;">
                <input type="hidden" name="url" value="search">
                <div class="input-group input-group-sm">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm tài nguyên...">
                    <button class="btn btn-outline-secondary bg-white text-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center me-3">
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=home">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=about">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=products">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=news">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=faqs">FAQs</a></li>
                <li class="nav-item"><a class="nav-link" href="public_entry.php?url=contact">Liên hệ</a></li>
            </ul>

            <div class="d-flex align-items-center">
                <?php if (!$isLoggedIn): ?>
                    <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#loginModal">Bắt đầu ngay</button>
                <?php else: ?>
                    <a href="public_entry.php?url=cart" class="nav-link position-relative p-0 me-4" style="font-size: 1.4rem; color: #333;">
                        <i class="bi bi-cart3"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">0</span>
                    </a>
                    <div class="dropdown">
                        <img src="<?= htmlspecialchars($userAvatar) ?>" class="rounded-circle border border-2 border-primary dropdown-toggle" 
                             id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" 
                             style="width: 40px; height: 40px; cursor: pointer; object-fit: cover;">
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 dropdown-menu-custom" aria-labelledby="userMenu">
                            <li class="px-3 py-2 border-bottom mb-1">
                                <span class="d-block fw-bold small"><?= htmlspecialchars($userName) ?></span>
                                <small class="text-muted" style="font-size: 11px;"><?= $userRole === 'admin' ? 'Quản trị viên' : 'Thành viên' ?></small>
                            </li>
                            <?php if ($userRole === 'admin'): ?>
                                <li><a class="dropdown-item rounded-2" href="public_entry.php?url=users"><i class="bi bi-speedometer2 me-2"></i>Quản trị hệ thống</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item rounded-2" href="public_entry.php?url=profile"><i class="bi bi-person-circle me-2"></i>Hồ sơ cá nhân</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold rounded-2" href="javascript:void(0)" onclick="confirmLogout()">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Bạn muốn đăng xuất?',
        text: "Mọi phiên làm việc hiện tại sẽ kết thúc!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Đồng ý, Thoát!',
        cancelButtonText: 'Ở lại'
    }).then((result) => { if (result.isConfirmed) { window.location.href = 'public_entry.php?url=logout'; } })
}
</script>