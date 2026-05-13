<div class="bg-light py-3 border-bottom">
    <div class="container"><a href="public_entry.php?url=home" class="text-decoration-none text-muted"><i class="fas fa-home"></i> Trang chủ</a> <i class="fas fa-chevron-right text-muted mx-2" style="font-size:10px;"></i> <b>Tất cả sản phẩm</b></div>
</div>

<style>
    /* Hiệu ứng Hover Hiện nút Add to Cart */
    .product-card { transition: all 0.3s ease; border: 1px solid #eee; overflow: hidden; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; border-color: #1abc9c; }
    .product-actions { position: absolute; bottom: -50px; left: 0; width: 100%; transition: all 0.3s ease; opacity: 0; background: rgba(255,255,255,0.95); padding: 10px; z-index: 10; }
    .product-card:hover .product-actions { bottom: 0; opacity: 1; }
    /* Discount Badge */
    .badge-discount { position: absolute; top: 10px; left: 10px; z-index: 10; font-size: 0.85rem; font-weight: bold; background: #e74c3c; color: white; padding: 5px 10px; border-radius: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    /* Carousel mũi tên */
    .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1); width: 1.5rem; height: 1.5rem; }
</style>

<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-4"><i class="fas fa-filter text-primary me-2"></i> Lọc Sản Phẩm</h5>
                <form action="public_entry.php" method="GET">
                    <input type="hidden" name="url" value="products">
                    
                    <div class="mb-4">
                        <label class="fw-bold text-dark mb-2">Danh mục</label>
                        <select name="category" class="form-select bg-light">
                            <option value="">Tất cả danh mục</option>
                            <?php foreach($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= isset($_GET['category']) && $_GET['category']==$c['id'] ? 'selected':'' ?>><?= $c['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-dark mb-2">Thương hiệu</label>
                        <select name="brand" class="form-select bg-light">
                            <option value="">Tất cả thương hiệu</option>
                            <?php foreach($brands as $b): ?>
                                <option value="<?= $b['brand'] ?>" <?= isset($_GET['brand']) && $_GET['brand']==$b['brand'] ? 'selected':'' ?>><?= $b['brand'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-dark mb-2">Sắp xếp theo</label>
                        <select name="sort" class="form-select bg-light">
                            <option value="newest">Mới nhất</option>
                            <option value="price_asc">Giá: Thấp đến Cao</option>
                            <option value="price_desc">Giá: Cao đến Thấp</option>
                            <option value="popular">Bán chạy nhất</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">Áp dụng Bộ Lọc</button>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <h4 class="fw-bold mb-4">Các sản phẩm nổi bật <span class="badge bg-danger rounded-pill fw-normal ms-2" style="font-size:14px;"><?= $totalProducts ?> Sản phẩm</span></h4>
            <div class="row g-4">
                <?php if(!empty($products)): foreach($products as $p): 
                    // Tính phần trăm giảm giá
                    $discountPct = ($p['old_price'] > $p['price']) ? round((($p['old_price'] - $p['price']) / $p['old_price']) * 100) : 0;
                    // Xử lý nhiều ảnh
                    $images = explode(',', $p['thumbnail']);
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 rounded-4 product-card position-relative">
                        
                        <?php if($discountPct > 0): ?>
                            <div class="badge-discount">-<?= $discountPct ?>%</div>
                        <?php endif; ?>

                        <div id="carouselProd<?= $p['id'] ?>" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                <?php foreach($images as $index => $img): ?>
                                    <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                        <a href="public_entry.php?url=product-detail&id=<?= $p['id'] ?>">
                                            <img src="<?= htmlspecialchars(trim($img)) ?>" class="w-100" style="height: 220px; object-fit: contain; padding: 15px;">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if(count($images) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProd<?= $p['id'] ?>" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselProd<?= $p['id'] ?>" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column pt-0">
                            <a href="public_entry.php?url=product-detail&id=<?= $p['id'] ?>" class="text-decoration-none text-dark fw-bold fs-6 mb-1 text-truncate"><?= htmlspecialchars($p['name']) ?></a>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted"><i class="fas fa-box"></i> Tồn: <?= $p['stock_count'] ?></small>
                                <small class="text-success fw-bold">Đã bán <?= $p['sold_count'] ?></small>
                            </div>

                            <div class="mt-auto">
                                <h5 class="text-danger fw-bold mb-0"><?= number_format($p['price'], 0, ',', '.') ?>đ</h5>
                                <?php if($discountPct > 0): ?>
                                    <small class="text-muted text-decoration-line-through"><?= number_format($p['old_price'], 0, ',', '.') ?>đ</small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="product-actions border-top">
                            <button onclick="addCartAjax(<?= $p['id'] ?>)" class="btn btn-outline-danger w-100 fw-bold rounded-pill shadow-sm">
                                <i class="fas fa-cart-plus me-1"></i> Thêm giỏ hàng
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <div class="col-12 text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" width="100" class="opacity-50 mb-3">
                        <h4 class="text-muted">Không tìm thấy sản phẩm nào!</h4>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($totalPages > 1): ?>
            <div class="d-flex justify-content-center mt-5">
                <nav><ul class="pagination pagination-lg shadow-sm">
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link px-4 fw-bold" href="?url=products&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                </ul></nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Dùng chung hàm này cho nút Thêm vào giỏ hàng ở cả trang danh sách và trang chi tiết
    const isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
    function addCartAjax(productId) {
        if (!isLoggedIn) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'warning', title: 'Bạn phải đăng nhập mới thêm vào giỏ hàng hoặc mua được!', showConfirmButton: false, timer: 2000 });
            return;
        }
        // ... (phần code cũ giữ nguyên)
        // Nếu ở trang chi tiết có ô nhập số lượng thì lấy, không thì mặc định là 1
        let qtyInput = document.getElementById('qty_detail');
        let qty = qtyInput ? qtyInput.value : 1;

        let fd = new FormData();
        fd.append('product_id', productId);
        fd.append('quantity', qty);

        fetch('public_entry.php?url=cart-add-ajax', { method: 'POST', body: fd })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'unauthorized') {
                // Nếu chưa đăng nhập, chuyển hướng sang trang đăng nhập ngay lập tức
                window.location.href = 'public_entry.php?url=login';
            } else if(data.status === 'success') {
                // Pop-up báo thành công tự tắt sau 1 giây (1000ms)
                Swal.fire({ 
                    toast: true, position: 'top-end', icon: 'success', 
                    title: data.message, showConfirmButton: false, timer: 1000 
                });
                
                // CẬP NHẬT TRỰC TIẾP SỐ LƯỢNG TRÊN HEADER (Tìm thẻ có id="cartCount")
                let cartBadge = document.getElementById('cartCount');
                if(cartBadge) {
                    cartBadge.innerText = data.cart_count;
                    // Thêm hiệu ứng rung/chớp nhẹ cho user chú ý
                    cartBadge.classList.add('animate__animated', 'animate__rubberBand');
                    setTimeout(() => cartBadge.classList.remove('animate__animated', 'animate__rubberBand'), 1000);
                }
            } else {
                Swal.fire({ 
                    toast: true, position: 'top-end', icon: 'error', 
                    title: data.message, showConfirmButton: false, timer: 1000 
                });
            }
        });
    }
</script>