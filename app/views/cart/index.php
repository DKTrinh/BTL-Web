<div class="bg-light py-3 border-bottom">
    <div class="container"><a href="public_entry.php?url=products" class="text-decoration-none text-muted"><i class="fas fa-chevron-left"></i> Tiếp tục mua sắm</a></div>
</div>

<div class="container py-5" style="min-height: 70vh;">
    <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart text-danger me-2"></i> Giỏ hàng của bạn</h2>
    
    <?php if(empty($cart)): ?>
        <div class="text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="150" class="mb-3 opacity-50">
            <h4 class="text-muted fw-bold">Giỏ hàng trống</h4>
            <p class="text-secondary">Bạn ơi, mua sắm đi chờ chi!</p>
            <a href="public_entry.php?url=products" class="btn btn-danger mt-3 px-5 py-3 fw-bold rounded-pill shadow-sm">Đến Cửa Hàng Ngay</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <?php 
                        $subtotal = 0;
                        foreach($cart as $id => $item): 
                            $itemTotal = $item['price'] * $item['qty'];
                            $subtotal += $itemTotal;
                        ?>
                        <div class="row align-items-center mb-4 pb-4 border-bottom item-row">
                            <div class="col-3 col-md-2 text-center">
                                <img src="<?= htmlspecialchars($item['thumbnail']) ?>" class="img-fluid rounded border p-1" alt="<?= htmlspecialchars($item['name']) ?>">
                            </div>
                            <div class="col-9 col-md-4">
                                <h6 class="fw-bold mb-1 text-dark" style="line-height: 1.4;"><?= htmlspecialchars($item['name']) ?></h6>
                                <div class="text-danger fw-bold"><?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                            </div>
                            <div class="col-6 col-md-3 mt-3 mt-md-0">
                                <div class="input-group input-group-sm mx-auto" style="max-width: 120px;">
                                    <button class="btn btn-outline-secondary fw-bold" onclick="updateQty(<?= $id ?>, -1)">-</button>
                                    <input type="text" class="form-control text-center fw-bold" value="<?= $item['qty'] ?>" readonly id="qty-<?= $id ?>">
                                    <button class="btn btn-outline-secondary fw-bold" onclick="updateQty(<?= $id ?>, 1)">+</button>
                                </div>
                            </div>
                            <div class="col-4 col-md-2 mt-3 mt-md-0 text-end">
                                <div class="fw-bold text-dark fs-6"><?= number_format($itemTotal, 0, ',', '.') ?>đ</div>
                            </div>
                            <div class="col-2 col-md-1 mt-3 mt-md-0 text-end">
                                <a href="public_entry.php?url=cart-remove&id=<?= $id ?>" class="text-danger fs-5 btn-remove"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Box Thanh toán -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-3">Tóm tắt đơn hàng</h5>
                        
                        <div class="input-group mb-3">
                            <input type="text" id="couponCode" class="form-control bg-light" placeholder="Nhập mã ưu đãi (nếu có)">
                            <button class="btn btn-dark fw-bold px-3" onclick="applyCoupon()">Áp dụng</button>
                        </div>
                        <small id="couponMsg" class="d-block mb-4 fw-bold"></small>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted fw-semibold">Tạm tính:</span>
                            <span class="fw-bold text-dark" id="subtotal"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>
                        
                        <!-- Dòng hiển thị giảm giá ẩn mặc định -->
                        <div class="d-flex justify-content-between mb-3 text-success d-none" id="discountRow">
                            <span class="fw-semibold">Mã giảm giá:</span>
                            <span class="fw-bold" id="discountAmt">-0đ</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4 border-top pt-3">
                            <span class="fs-5 fw-bold">Tổng cộng:</span>
                            <span class="fs-4 fw-bold text-danger" id="finalTotal"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>
                        
                        <a href="public_entry.php?url=checkout" class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm rounded-3">TIẾN HÀNH ĐẶT HÀNG</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // Hàm cập nhật số lượng qua AJAX (Gọi đến hàm bạn đã thêm ở OrderController)
    function updateQty(id, change) {
        let input = document.getElementById('qty-' + id);
        let newQty = parseInt(input.value) + change;
        if(newQty < 1) return; // Không cho giảm dưới 1
        
        let fd = new FormData();
        fd.append('id', id);
        fd.append('qty', newQty);
        
        fetch('public_entry.php?url=update-cart', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.reload(); // Load lại để tính lại tổng tiền
            } else {
                alert('Sản phẩm trong kho chỉ còn tối đa ' + data.max + ' cái!');
            }
        });
    }

    // Hàm áp dụng mã giảm giá (Mã test: voucher, coupon, apple)
    function applyCoupon() {
        let code = document.getElementById('couponCode').value;
        if(!code) return;
        
        let fd = new FormData();
        fd.append('code', code);
        
        fetch('public_entry.php?url=apply-coupon', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            let msgBox = document.getElementById('couponMsg');
            let row = document.getElementById('discountRow');
            let amt = document.getElementById('discountAmt');
            let total = document.getElementById('finalTotal');
            
            if(data.success) {
                msgBox.className = "d-block mb-4 fw-bold text-success";
                msgBox.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                row.classList.remove('d-none');
                amt.innerText = '-' + data.discount.toLocaleString('vi-VN') + 'đ';
                total.innerText = data.newTotal.toLocaleString('vi-VN') + 'đ';
            } else {
                msgBox.className = "d-block mb-4 fw-bold text-danger";
                msgBox.innerHTML = '<i class="fas fa-times-circle"></i> ' + data.message;
                row.classList.add('d-none');
                total.innerText = document.getElementById('subtotal').innerText; // Trả về giá gốc
            }
        });
    }
</script>

<form action="public_entry.php?url=checkout" method="POST">
    <div class="card-body p-4">
        <!-- Checkbox chọn tất cả -->
        <div class="form-check mb-3 pb-3 border-bottom">
            <input class="form-check-input" type="checkbox" id="selectAll" onclick="toggleAll(this)">
            <label class="form-check-label fw-bold" for="selectAll">Chọn tất cả sản phẩm</label>
        </div>

        <?php foreach($cart as $id => $item): ?>
        <div class="row align-items-center mb-4 pb-4 border-bottom">
            <div class="col-1">
                <input class="form-check-input item-check" type="checkbox" name="selected_items[]" value="<?= $id ?>" onchange="calcTotal()">
            </div>
            <!-- Hiển thị Ảnh, Tên, Giá, Nút +/- (giữ nguyên như trước) -->
            ...
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Box Tóm tắt -->
    <div class="col-lg-4">
        <h4 class="fw-bold">Tổng tiền: <span id="displayTotal" class="text-danger">0đ</span></h4>
        <button type="submit" id="btnCheckout" class="btn btn-danger w-100 py-3 fw-bold fs-5" disabled>MUA HÀNG</button>
    </div>
</form>

<script>
    function calcTotal() {
        let total = 0;
        let checkboxes = document.querySelectorAll('.item-check');
        let hasChecked = false;
        checkboxes.forEach(cb => {
            if(cb.checked) {
                hasChecked = true;
                // Lấy giá trị tương ứng của sản phẩm để cộng dồn
            }
        });
        document.getElementById('btnCheckout').disabled = !hasChecked;
    }
    function toggleAll(source) {
        document.querySelectorAll('.item-check').forEach(cb => cb.checked = source.checked);
        calcTotal();
    }
</script>