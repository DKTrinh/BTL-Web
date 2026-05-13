<?php 
// Xử lý chuỗi ảnh (nếu có nhiều ảnh cách nhau bằng dấu phẩy)
$images = explode(',', $product['thumbnail']); 
// Tính % giảm giá
$discountPct = ($product['old_price'] > $product['price']) ? round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) : 0;
?>

<div class="bg-light py-3 border-bottom">
    <div class="container"><a href="public_entry.php?url=products" class="text-decoration-none text-muted"><i class="fas fa-chevron-left"></i> Trở về Cửa hàng</a></div>
</div>

<div class="container py-5">
    <div class="row g-5 bg-white p-4 p-md-5 rounded-4 shadow-sm border">
        
        <div class="col-md-6 text-center position-relative">
            <?php if($discountPct > 0): ?>
                <div class="position-absolute top-0 start-0 z-3 badge bg-danger fs-5 px-3 py-2 rounded-pill shadow-sm" style="margin: 10px;">
                    -<?= $discountPct ?>%
                </div>
            <?php endif; ?>

            <div id="productDetailCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 shadow-sm border bg-light">
                    <?php foreach($images as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-bs-interval="3000">
                            <img src="<?= htmlspecialchars(trim($img)) ?>" class="d-block w-100" style="height: 450px; object-fit: contain; padding: 20px;" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if(count($images) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productDetailCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productDetailCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <span class="badge bg-primary fs-6 mb-3 px-3 py-2 rounded-pill"><?= htmlspecialchars($product['brand']) ?></span>
            <h1 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h1>
            <div class="d-flex align-items-center mb-4">
                <div class="text-warning fs-5 me-2">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-muted fw-bold border-start ps-3 ms-2">Đã bán <?= $product['sold_count'] ?></span>
                <span class="text-muted fw-bold border-start ps-3 ms-3">Kho: <?= $product['stock_count'] ?></span>
            </div>
            
            <div class="bg-light p-4 rounded-4 mb-4 border">
                <h2 class="text-danger fw-bold mb-0" style="font-size: 2.5rem;"><?= number_format($product['price'], 0, ',', '.') ?> đ</h2>
                <?php if($product['old_price'] > $product['price']): ?>
                    <div class="text-muted mt-2 fs-5 text-decoration-line-through">Giá gốc: <?= number_format($product['old_price'], 0, ',', '.') ?> đ</div>
                <?php endif; ?>
            </div>

            <p class="text-secondary fs-5 mb-4" style="line-height: 1.8;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            
            <div class="d-flex flex-wrap gap-3 align-items-center mt-5">
                
                <div class="input-group shadow-sm" style="width: 140px; height: 50px;">
                    <button class="btn btn-outline-secondary px-3 fw-bold" type="button" onclick="changeQty(-1)">-</button>
                    <input type="text" class="form-control text-center fw-bold fs-5 bg-white" id="qty_detail" value="1" readonly>
                    <button class="btn btn-outline-secondary px-3 fw-bold" type="button" onclick="changeQty(1)">+</button>
                </div>
                
                <button onclick="addCartAjax(<?= $product['id'] ?>)" class="btn btn-outline-danger flex-grow-1 fw-bold fs-5 shadow-sm" style="height: 50px;">
                    <i class="fas fa-cart-plus me-2"></i> THÊM GIỎ HÀNG
                </button>

                <form action="public_entry.php?url=buy-now" method="POST" class="flex-grow-1 m-0" onsubmit="buyNowAction(event)">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="quantity" id="buy_now_qty" value="1">
                    <button type="submit" class="btn btn-danger w-100 fw-bold fs-5 shadow" style="height: 50px;">
                        MUA NGAY
                    </button>
                </form>
            </div>
            
            <div class="alert alert-success mt-4 border-0 shadow-sm"><i class="fas fa-truck-fast me-2"></i> Miễn phí giao hàng toàn quốc cho đơn từ 1.000.000đ</div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Kiểm tra trạng thái đăng nhập từ Session PHP truyền thẳng vào JS
    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;

    function changeQty(val) {
        let q = document.getElementById('qty_detail');
        let nv = parseInt(q.value) + val;
        // Kiểm tra tồn kho
        if(nv >= 1 && nv <= <?= $product['stock_count'] ?>) {
            q.value = nv;
            document.getElementById('buy_now_qty').value = nv;
        } else if (nv > <?= $product['stock_count'] ?>) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'info', title: 'Số lượng vượt quá hàng trong kho!', showConfirmButton: false, timer: 2000 });
        }
    }

    // Xử lý thêm vào giỏ hàng
    function addCartAjax(productId) {
        if (!isLoggedIn) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Bạn phải đăng nhập mới thêm vào giỏ hàng hoặc mua được!', showConfirmButton: false, timer: 2000 });
            return;
        }

        let qty = document.getElementById('qty_detail').value;
        let fd = new FormData();
        fd.append('product_id', productId);
        fd.append('quantity', qty);

        fetch('public_entry.php?url=cart-add-ajax', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message, showConfirmButton: false, timer: 1000 });
                
                // Cập nhật số lượng trên Header
                let cartBadge = document.getElementById('cartCount');
                if(cartBadge) {
                    cartBadge.innerText = data.cart_count;
                }
            } else {
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: data.message, showConfirmButton: false, timer: 1000 });
            }
        });
    }

    // Xử lý nút Mua Ngay
    function buyNowAction(event) {
        if (!isLoggedIn) {
            event.preventDefault(); 
            Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Bạn phải đăng nhập mới thêm vào giỏ hàng hoặc mua được!', showConfirmButton: false, timer: 2000 });
        }
    }
</script>