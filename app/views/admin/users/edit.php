<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container-fluid py-4" style="background-color: #f4f6fa; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-info text-dark fw-bold text-center py-3">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Cập nhật Thành viên #<?= $user['id'] ?></h5>
                </div>
                <div class="card-body p-3 p-md-5">
                    <form action="public_entry.php?url=user-update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">

                        <?php include 'update.php'; ?>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-muted small">Họ và Tên</label>
                                <input type="text" name="fullname" class="form-control bg-light" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-muted small">Email (Tài khoản)</label>
                                <input type="email" name="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-muted small">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control bg-light" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-muted small">Phân quyền</label>
                                <select name="role" class="form-select border-primary">
                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label fw-bold text-muted small">Địa chỉ giao hàng</label>
                                    <a href="javascript:void(0)" class="small fw-bold text-success text-decoration-none" onclick="openAddressModal()">Sổ địa chỉ <i class="fas fa-book"></i></a>
                                </div>
                                <textarea name="address" id="main_address" class="form-control bg-light" rows="2"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-info fw-bold py-3 shadow-sm text-dark fs-5">LƯU TOÀN BỘ THAY ĐỔI</button>
                            <a href="public_entry.php?url=users" class="btn btn-outline-secondary py-2 fw-bold">Hủy bỏ / Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title fw-bold">Quản lý Sổ địa chỉ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="addressList" class="mb-3"></div>
                <div class="input-group">
                    <input type="text" id="newAddressInput" class="form-control" placeholder="Thêm địa chỉ mới...">
                    <button class="btn btn-success" onclick="addNewAddress()">Thêm</button>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary w-100 fw-bold" onclick="saveAddressSelection()" data-bs-dismiss="modal">Xác nhận chọn</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic Sổ địa chỉ
    function openAddressModal() {
        const addrs = document.getElementById('main_address').value.split('\n').filter(a => a.trim());
        let html = addrs.map((a, i) => `<div class="form-check mb-2 p-3 bg-light border rounded"><input class="form-check-input" type="radio" name="addrRadio" id="adr${i}" value="${a}" ${i===0?'checked':''}><label class="form-check-label ms-2 fw-bold" for="adr${i}">${a}</label></div>`).join('') || '<p class="text-muted">Trống</p>';
        document.getElementById('addressList').innerHTML = html;
        new bootstrap.Modal(document.getElementById('addressModal')).show();
    }
    function addNewAddress() {
        const val = document.getElementById('newAddressInput').value.trim();
        if(val) { document.getElementById('addressList').innerHTML += `<div class="form-check mb-2 p-3 bg-light border rounded"><input class="form-check-input" type="radio" name="addrRadio" value="${val}" checked><label class="form-check-label ms-2 fw-bold">${val}</label></div>`; document.getElementById('newAddressInput').value = ''; }
    }
    function saveAddressSelection() {
        const selected = document.querySelector('input[name="addrRadio"]:checked');
        if(selected) {
            const all = Array.from(document.querySelectorAll('input[name="addrRadio"]')).map(el => el.value);
            const reordered = [selected.value, ...all.filter(a => a !== selected.value)];
            document.getElementById('main_address').value = reordered.join('\n');
        }
    }
</script>
<?php require_once '../app/views/layouts/footer.php'; ?>