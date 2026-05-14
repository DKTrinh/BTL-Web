<?php 
// Mặc định tab là users nếu không có tham số truyền vào
$current_tab = $_GET['tab'] ?? 'users'; 
?>
<style>
    /* GIỮ NGUYÊN CSS CŨ CỦA BẠN */
    .main-header { z-index: 1050 !important; }
    .sidebar-link { transition: all 0.3s ease; border-radius: 8px; font-weight: 500;}
    .sidebar-link:hover { background-color: rgba(255,255,255,0.15); transform: translateX(8px); color: #1abc9c !important; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.2);}
    
    #drop-zone-admin { border: 2px dashed #17a2b8; border-radius: 50%; width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; margin: 0 auto; cursor: pointer; background: #f0f2f5; }
    #drop-zone-admin img { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1; }
    #drop-zone-admin .overlay { position: absolute; z-index: 2; background: rgba(0,0,0,0.5); color: white; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; }
    #drop-zone-admin:hover .overlay { opacity: 1; }
</style>

<div class="d-flex" style="min-height: 90vh; background-color: #f4f6fa;">
    
    <div class="bg-dark text-white p-3 shadow-lg" style="width: 270px;">
        <h5 class="fw-bold mb-4 mt-2 text-center text-info" style="letter-spacing: 1px;"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2 mt-4">
            <a href="public_entry.php?url=users&tab=users" class="nav-link sidebar-link <?= $current_tab == 'users' ? 'active' : 'text-white' ?>"><i class="fas fa-users me-2"></i> Quản lý Thành viên</a>
            <a href="public_entry.php?url=users&tab=faq" class="nav-link sidebar-link <?= $current_tab == 'faq' ? 'active' : 'text-white' ?>"><i class="fas fa-question-circle me-2"></i> Quản lý Hỏi & Đáp</a>
            <a href="public_entry.php?url=users&tab=about" class="nav-link sidebar-link <?= $current_tab == 'about' ? 'active' : 'text-white' ?>"><i class="fas fa-info-circle me-2"></i> Quản lý Giới thiệu</a>
            
            <a href="#" class="nav-link text-white sidebar-link"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="nav-link text-white sidebar-link"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
        </div>
    </div>

    <div class="flex-grow-1 p-4">
        
        <?php if($current_tab == 'users'): ?>
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border-start border-5 border-info">
                <h3 class="fw-bold text-dark m-0"><i class="fas fa-users-cog me-2 text-info"></i> Quản lý Thành viên</h3>
                <button class="btn btn-primary fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-2"></i> Thêm thành viên
                </button>
            </div>
            
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #0b2b44; color: white;">
                            <tr>
                                <th class="ps-4 py-3">User</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if(!empty($users)): ?>
                                <?php foreach($users as $u): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= !empty($u['avatar']) ? $u['avatar'] : 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>" class="rounded-circle me-3" width="40" height="40">
                                            <div><div class="fw-bold text-dark"><?= htmlspecialchars($u['fullname']) ?></div><div class="small text-muted">ID: #<?= $u['id'] ?></div></div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['phone'] ?? '---') ?></td>
                                    <td><?= $u['role'] === 'admin' ? '<span class="badge bg-danger rounded-pill px-3 py-2">Admin</span>' : '<span class="badge bg-info text-dark rounded-pill px-3 py-2">Khách</span>' ?></td>
                                    <td><?= $u['status'] == 1 ? '<span class="badge bg-success rounded-pill px-3 py-2">Hoạt động</span>' : '<span class="badge bg-secondary rounded-pill px-3 py-2">Bị cấm</span>' ?></td>
                                    <td class="text-center py-3">
                                        <button class="btn btn-sm btn-info fw-bold text-dark shadow-sm btn-edit-user" data-id="<?= $u['id'] ?>" data-fullname="<?= htmlspecialchars($u['fullname']) ?>" data-email="<?= htmlspecialchars($u['email']) ?>" data-role="<?= $u['role'] ?>" data-avatar="<?= !empty($u['avatar']) ? $u['avatar'] : 'https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>">
                                            <i class="fas fa-eye"></i> Xem/Sửa
                                        </button>
                                        <button class="btn btn-sm fw-bold text-white shadow-sm <?= $u['status'] == 1 ? 'btn-danger' : 'btn-success' ?>" onclick="toggleLock(<?= $u['id'] ?>, <?= $u['status'] ?>)">
                                            <i class="fas <?= $u['status'] == 1 ? 'fa-ban' : 'fa-unlock' ?>"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php elseif($current_tab == 'faq'): ?>
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border-start border-5 border-success">
                <h3 class="fw-bold text-dark m-0"><i class="fas fa-question-circle me-2 text-success"></i> Quản lý Hỏi & Đáp</h3>
            </div>
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-dark text-white">
                        <tr><th>Mã REQ</th><th>Chủ đề</th><th>Câu hỏi</th><th>Trạng thái</th><th>Thao tác</th></tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($faqs)): foreach($faqs as $f): ?>
                        <tr>
                            <td>#<?= $f['f_id'] ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($f['title']) ?></span></td>
                            <td class="text-start"><?= htmlspecialchars(substr($f['question'], 0, 50)) ?>...</td>
                            <td><span class="badge <?= $f['status'] == 'answered' ? 'bg-success' : 'bg-warning' ?>"><?= $f['status'] ?></span></td>
                            <td>
                                <a href="public_entry.php?url=admin/faq/edit&id=<?= $f['f_id'] ?>" class="btn btn-sm btn-warning">Sửa/Duyệt</a>
                            </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($current_tab == 'about'): ?>
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border-start border-5 border-warning">
                <h3 class="fw-bold text-dark m-0"><i class="fas fa-info-circle me-2 text-warning"></i> Chỉnh sửa trang Giới thiệu</h3>
            </div>
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <form action="public_entry.php?url=admin/about-update" method="POST">
                    <?php foreach($contents as $key => $c): ?>
                    <div class="mb-4">
                        <label class="fw-bold text-muted small mb-2 text-uppercase"><?= htmlspecialchars($c['section_name']) ?></label>
                        <textarea name="content[<?= $key ?>]" class="form-control bg-light" rows="4"><?= htmlspecialchars($c['content_value']) ?></textarea>
                    </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-warning fw-bold px-5 py-2 shadow-sm">LƯU THAY ĐỔI</button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1">
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // POPUP THÔNG BÁO
    <?php if (isset($_SESSION['auth_status'])): ?>
        Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, icon: '<?= $_SESSION['auth_status'] ?>', title: '<?= $_SESSION['auth_message'] ?>' });
        <?php unset($_SESSION['auth_status'], $_SESSION['auth_message']); ?>
    <?php endif; ?>

    // BẮT SỰ KIỆN NÚT "XEM / SỬA" BẰNG JAVASCRIPT
    document.querySelectorAll('.btn-edit-user').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_fullname').value = this.dataset.fullname;
            document.getElementById('edit_email').value = this.dataset.email;
            document.getElementById('edit_role').value = this.dataset.role;
            document.getElementById('edit_phone').value = this.dataset.phone;
            document.getElementById('edit_gender').value = this.dataset.gender;
            document.getElementById('edit_birthdate').value = this.dataset.birthdate;
            document.getElementById('edit_address').value = this.dataset.address;
            document.getElementById('edit_avatar_preview').src = this.dataset.avatar;
            
            // Bật Pop-up lên
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        });
    });

    // Kéo thả Ảnh Admin
    const aInput = document.getElementById('edit_avatar_input');
    aInput.addEventListener('change', function() {
        if(this.files.length) {
            const reader = new FileReader();
            reader.onload = (e) => document.getElementById('edit_avatar_preview').src = e.target.result;
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Sổ Địa chỉ Admin Modal
    function openAdminAddressModal() {
        const addrs = document.getElementById('edit_address').value.split('\n').filter(a => a.trim());
        let html = addrs.map((a, i) => `<div class="form-check mb-2 p-2 border rounded"><input class="form-check-input ms-1" type="radio" name="adminAddrRadio" id="a_adr${i}" value="${a}" ${i===0?'checked':''}><label class="form-check-label ms-2 fw-bold" for="a_adr${i}">${a}</label></div>`).join('') || '<p class="text-muted">Trống</p>';
        document.getElementById('adminAddressList').innerHTML = html;
        new bootstrap.Modal(document.getElementById('adminAddressModal')).show();
    }
    function addAdminAddress() {
        const val = document.getElementById('adminNewAddressInput').value.trim();
        if(val) { document.getElementById('adminAddressList').innerHTML += `<div class="form-check mb-2 p-2 border rounded"><input class="form-check-input ms-1" type="radio" name="adminAddrRadio" value="${val}" checked><label class="form-check-label ms-2 fw-bold">${val}</label></div>`; document.getElementById('adminNewAddressInput').value = ''; }
    }
    function saveAdminAddressSelection() {
        const selected = document.querySelector('input[name="adminAddrRadio"]:checked');
        if(selected) {
            const all = Array.from(document.querySelectorAll('input[name="adminAddrRadio"]')).map(el => el.value);
            const reordered = [selected.value, ...all.filter(a => a !== selected.value)];
            document.getElementById('edit_address').value = reordered.join('\n');
        }
    }

    function toggleLock(id, currentStatus) {
        Swal.fire({
            title: currentStatus == 1 ? 'Cấm người này?' : 'Mở khóa?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: currentStatus == 1 ? '#e74c3c' : '#2ecc71', confirmButtonText: 'Xác nhận'
        }).then((res) => { if(res.isConfirmed) window.location.href = `public_entry.php?url=user-lock&id=${id}`; });
    }

    function resetPass(id) {
        Swal.fire({
            title: 'Cấp mật khẩu mới', showDenyButton: true, showCancelButton: true,
            confirmButtonText: 'Tự nhập', denyButtonText: 'Ngẫu nhiên'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Nhập mật khẩu', input: 'text', showCancelButton: true }).then((r) => {
                    if (r.isConfirmed && r.value) submitAjaxReset(id, 'manual', r.value);
                });
            } else if (result.isDenied) submitAjaxReset(id, 'random', '');
        });
    }

    function submitAjaxReset(id, type, password) {
        let fd = new FormData(); fd.append('id', id); fd.append('type', type); fd.append('password', password);
        fetch('public_entry.php?url=user-reset', { method: 'POST', body: fd })
        .then(res => res.json()).then(data => {
            if (data.status === 'success') {
                if(data.type === 'random') Swal.fire('Thành công', 'Pass mới: <b>' + data.password + '</b>', 'success');
                else Swal.fire({ title: 'Thành công', icon: 'success', timer: 2000 });
            }
        });
    }
</script>