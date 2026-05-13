<div class="bg-light py-3 border-bottom">
    <div class="container"><a href="public_entry.php?url=cart" class="text-decoration-none text-muted"><i class="fas fa-chevron-left"></i> Quay lại giỏ hàng</a></div>
</div>

<div class="container py-5">
    <form action="public_entry.php?url=checkout-process" method="POST" id="checkoutForm">
        <div class="row g-5">
            <!-- Form điền thông tin -->
            <div class="col-lg-7">
                <h3 class="fw-bold mb-4"><i class="fas fa-map-marker-alt text-danger me-2"></i> Thông tin giao hàng</h3>
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Họ và Tên người nhận</label>
                            <input type="text" name="fullname" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Email (Để nhận hóa đơn)</label>
                            <input type="email" name="email" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Số điện thoại liên hệ</label>
                            <input type="text" name="phone" class="form-control form-control-lg bg-light" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Địa chỉ nhận hàng chi tiết</label>
                            <textarea name="address" class="form-control form-control-lg bg-light" rows="3" required placeholder="Ví dụ: 123 Lê Lợi, Phường Bến Thành, Quận 1..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Ghi chú (Tùy chọn)</label>
                            <textarea name="note" class="form-control form-control-lg bg-light" rows="2" placeholder="Ví dụ: Giao hàng vào giờ hành chính, gọi trước khi giao..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tóm tắt Đơn hàng -->
            <div class="col-lg-5">
                <h3 class="fw-bold mb-4"><i class="fas fa-receipt text-primary me-2"></i> Đơn hàng của bạn</h3>
                <div class="card border-0 shadow-sm rounded-4 p-4 position-sticky" style="top: 100px;">
                    <div class="order-items-wrapper mb-3" style="max-height: 300px; overflow-y: auto;">
                        <?php 
                        $subtotal = 0;
                        foreach($checkoutItems as $item): 
                            $subtotal += $item['price'] * $item['qty'];
                        ?>
                        <div class="d-flex align-items-center justify-content-between mb-3 pe-2">
                            <div class="d-flex align-items-center">
                                <div class="position-relative">
                                    <img src="<?= htmlspecialchars($item['thumbnail']) ?>" width="60" class="rounded border p-1 me-3 bg-white">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light"><?= $item['qty'] ?></span>
                                </div>
                                <div>
                                    <div class="fw-bold small text-truncate text-dark" style="max-width: 180px;"><?= htmlspecialchars($item['name']) ?></div>
                                </div>
                            </div>
                            <div class="fw-bold text-dark"><?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?>đ</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <hr class="text-muted border-dashed">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted fw-semibold">Tạm tính</span>
                        <span class="fw-bold"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                    </div>
                    
                    <?php 
                    $discount = $_SESSION['discount'] ?? 0;
                    $final = $subtotal - $discount;
                    if($discount > 0): 
                    ?>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span class="fw-semibold"><i class="fas fa-tag"></i> Giảm giá khuyến mãi</span>
                        <span class="fw-bold">-<?= number_format($discount, 0, ',', '.') ?>đ</span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted fw-semibold">Phí vận chuyển</span>
                        <span class="fw-bold text-success">Miễn phí</span>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 mb-4 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5 fw-bold text-dark">Tổng thanh toán</span>
                            <span class="fs-3 fw-bold text-danger"><?= number_format($final, 0, ',', '.') ?>đ</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm rounded-3">XÁC NHẬN ĐẶT HÀNG</button>
                    <p class="text-center text-muted small mt-3 mb-0"><i class="fas fa-shield-alt"></i> Thông tin của bạn được bảo mật tuyệt đối</p>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Nút Mở Sổ Địa Chỉ -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold m-0"><i class="fas fa-map-marker-alt text-danger me-2"></i> Thông tin nhận hàng</h3>
    <button type="button" class="btn btn-outline-success btn-sm fw-bold" onclick="openAddressBook()">
        <i class="fas fa-address-book"></i> Chọn từ Sổ địa chỉ
    </button>
</div>

<!-- Form Thông Tin (Có ID để JS điền tự động) -->
<input type="text" id="chk_name" name="fullname" class="form-control mb-3" value="<?= htmlspecialchars($user['fullname']) ?>">
<input type="text" id="chk_phone" name="phone" class="form-control mb-3" value="<?= htmlspecialchars($user['phone']) ?>">
<textarea id="chk_addr" name="address" class="form-control mb-3"><?= htmlspecialchars($user['address']) ?></textarea>

<!-- Nút Lưu Địa Chỉ Mới -->
<div class="form-check mt-2">
    <input class="form-check-input" type="checkbox" id="saveNewAddr">
    <label class="form-check-label text-primary fw-bold" for="saveNewAddr">Lưu thông tin này vào Sổ địa chỉ để dùng lần sau</label>
</div>

<!-- POP-UP SỔ ĐỊA CHỈ -->
<div class="modal fade" id="addressBookModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="fw-bold">Sổ địa chỉ của bạn</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light" id="addressListContainer">
                <!-- Javascript sẽ render danh sách địa chỉ vào đây -->
            </div>
        </div>
    </div>
</div>

<script>
    // Khởi tạo Sổ địa chỉ sử dụng LocalStorage (Gắn với ID của user hiện tại để không bị nhầm)
    const userKey = 'addressBook_User<?= $user['id'] ?>';
    
    function getAddressBook() {
        let data = localStorage.getItem(userKey);
        return data ? JSON.parse(data) : [];
    }

    function saveToAddressBook(name, phone, address) {
        let book = getAddressBook();
        // Tránh lưu trùng
        let exists = book.some(b => b.name === name && b.phone === phone && b.address === address);
        if(!exists) {
            book.push({name, phone, address});
            localStorage.setItem(userKey, JSON.stringify(book));
        }
    }

    // Mở Pop-up
    function openAddressBook() {
        let book = getAddressBook();
        let html = '';
        if(book.length === 0) {
            html = '<p class="text-center text-muted py-3">Sổ địa chỉ trống.</p>';
        } else {
            book.forEach((item, index) => {
                html += `
                <div class="card border-0 shadow-sm mb-3 cursor-pointer" onclick="selectAddress(${index})">
                    <div class="card-body">
                        <div class="fw-bold fs-6 text-dark">${item.name} <span class="text-secondary fw-normal">| ${item.phone}</span></div>
                        <div class="text-muted small mt-1">${item.address}</div>
                        <button class="btn btn-sm btn-outline-danger mt-2" onclick="deleteAddress(event, ${index})">Xóa</button>
                    </div>
                </div>`;
            });
        }
        document.getElementById('addressListContainer').innerHTML = html;
        new bootstrap.Modal(document.getElementById('addressBookModal')).show();
    }

    // Khi khách hàng chọn 1 địa chỉ trong Pop-up
    function selectAddress(index) {
        let book = getAddressBook();
        let item = book[index];
        document.getElementById('chk_name').value = item.name;
        document.getElementById('chk_phone').value = item.phone;
        document.getElementById('chk_addr').value = item.address;
        
        bootstrap.Modal.getInstance(document.getElementById('addressBookModal')).hide();
    }

    function deleteAddress(e, index) {
        e.stopPropagation(); // Ngăn sự kiện click chọn thẻ
        let book = getAddressBook();
        book.splice(index, 1);
        localStorage.setItem(userKey, JSON.stringify(book));
        openAddressBook(); // Render lại
    }

    // Khi ấn Đặt Hàng (Submit Form)
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        if(document.getElementById('saveNewAddr').checked) {
            saveToAddressBook(
                document.getElementById('chk_name').value,
                document.getElementById('chk_phone').value,
                document.getElementById('chk_addr').value
            );
        }
    });
</script>