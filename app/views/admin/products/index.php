<style>
    .main-header { z-index: 1050 !important; }
    .sidebar-link { transition: all 0.3s ease; border-radius: 8px; font-weight: 500;}
    .sidebar-link:hover { background-color: rgba(255,255,255,0.15); transform: translateX(8px); color: #1abc9c !important; }
    .sidebar-link.active { background-color: #1e6f5c !important; color: white !important; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.2);}
</style>

<div class="d-flex" style="min-height: 90vh; background-color: #f4f6fa;">
    <div class="bg-dark text-white p-3 shadow-lg" style="width: 270px;">
        <h5 class="fw-bold mb-4 mt-2 text-center text-info" style="letter-spacing: 1px;"><i class="fas fa-microchip me-2"></i> TECHZONE</h5>
        <div class="nav flex-column gap-2 mt-4">
            <a href="#" class="nav-link text-white sidebar-link"><i class="fas fa-chart-pie me-2"></i> Tổng quan</a>
            <a href="public_entry.php?url=users" class="nav-link text-white sidebar-link"><i class="fas fa-users me-2"></i> Quản lý Thành viên</a>
            <a href="public_entry.php?url=admin-products" class="nav-link sidebar-link active"><i class="fas fa-box-open me-2"></i> Quản lý Sản phẩm</a>
            <a href="#" class="nav-link text-white sidebar-link"><i class="fas fa-newspaper me-2"></i> Quản lý Tin tức</a>
            <a href="#" class="nav-link text-white sidebar-link"><i class="fas fa-comments me-2"></i> Quản lý Bình luận</a>
        </div>
    </div>

    <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border-start border-5 border-success">
            <h3 class="fw-bold text-dark m-0"><i class="fas fa-box-open me-2 text-success"></i> Kho Sản Phẩm</h3>
            <button class="btn btn-success fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-2"></i> Thêm Sản Phẩm Mới
            </button>
        </div>
        
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #0b2b44; color: white;">
                        <tr>
                            <th class="ps-4 py-3">Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Giá bán</th>
                            <th>Kho/Đã bán</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php if(!empty($products)): foreach($products as $p): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="<?= htmlspecialchars($p['thumbnail']) ?>" class="rounded me-3 border" width="50" height="50" style="object-fit:cover;">
                                    <div>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;"><?= htmlspecialchars($p['name']) ?></div>
                                        <div class="small text-muted">ID: #<?= $p['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p['category_name'] ?? 'Khác') ?></span></td>
                            <td class="fw-bold text-secondary"><?= htmlspecialchars($p['brand']) ?></td>
                            <td class="fw-bold text-danger"><?= number_format($p['price'], 0, ',', '.') ?>đ</td>
                            <td><?= $p['stock_count'] ?> / <span class="text-success"><?= $p['sold_count'] ?></span></td>
                            <td class="text-center py-3">
                                <button class="btn btn-sm btn-warning fw-bold text-dark shadow-sm btn-edit-product"
                                        data-id="<?= $p['id'] ?>" data-name="<?= htmlspecialchars($p['name']) ?>"
                                        data-price="<?= $p['price'] ?>" data-oldprice="<?= $p['old_price'] ?>"
                                        data-cat="<?= $p['category_id'] ?>" data-brand="<?= htmlspecialchars($p['brand']) ?>"
                                        data-stock="<?= $p['stock_count'] ?>" data-desc="<?= htmlspecialchars($p['description']) ?>"
                                        data-thumb="<?= $p['thumbnail'] ?>">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <button class="btn btn-sm btn-danger fw-bold text-white shadow-sm" onclick="deleteProduct(<?= $p['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">Không có sản phẩm nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if(isset($totalPages) && $totalPages > 1): ?>
            <div class="card-footer bg-white p-3 d-flex justify-content-end border-top">
                <nav><ul class="pagination mb-0">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="?url=admin-products&page=<?= $page - 1 ?>">Trước</a></li>
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link" href="?url=admin-products&page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="?url=admin-products&page=<?= $page + 1 ?>">Sau</a></li>
                </ul></nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0"><h5 class="modal-title fw-bold">Thêm Sản Phẩm Mới</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <form action="public_entry.php?url=admin-product-store" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-8"><label class="fw-bold small text-muted">Tên sản phẩm</label><input type="text" name="name" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Thương hiệu</label><input type="text" name="brand" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Giá bán (VNĐ)</label><input type="number" name="price" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Giá cũ (Thị trường)</label><input type="number" name="old_price" class="form-control"></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>"><?= $c['name'] ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Số lượng kho</label><input type="number" name="stock_count" class="form-control" value="100"></div>
                    <div class="col-md-8"><label class="fw-bold small text-muted">Hình ảnh (Thumbnail)</label><input type="file" name="thumbnail" class="form-control" accept="image/*" required></div>
                    <div class="col-12"><label class="fw-bold small text-muted">Mô tả sản phẩm</label><textarea name="description" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0"><button type="submit" class="btn w-100 fw-bold btn-success shadow-sm">Tạo Sản Phẩm</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark border-0"><h5 class="modal-title fw-bold">Chỉnh sửa Sản Phẩm</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="public_entry.php?url=admin-product-update" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4 row g-3">
                    <input type="hidden" name="id" id="e_id">
                    <div class="col-12 text-center mb-2"><img id="e_thumb_preview" src="" width="100" class="rounded border shadow-sm"></div>
                    <div class="col-md-8"><label class="fw-bold small text-muted">Tên sản phẩm</label><input type="text" name="name" id="e_name" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Thương hiệu</label><input type="text" name="brand" id="e_brand" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Giá bán (VNĐ)</label><input type="number" name="price" id="e_price" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Giá cũ</label><input type="number" name="old_price" id="e_old_price" class="form-control"></div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Danh mục</label>
                        <select name="category_id" id="e_cat" class="form-select">
                            <?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>"><?= $c['name'] ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="fw-bold small text-muted">Số lượng kho</label><input type="number" name="stock_count" id="e_stock" class="form-control"></div>
                    <div class="col-md-8"><label class="fw-bold small text-muted">Đổi hình ảnh mới (Bỏ trống nếu giữ nguyên)</label><input type="file" name="thumbnail" class="form-control" accept="image/*"></div>
                    <div class="col-12"><label class="fw-bold small text-muted">Mô tả sản phẩm</label><textarea name="description" id="e_desc" class="form-control" rows="3"></textarea></div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0"><button type="submit" class="btn w-100 fw-bold btn-warning shadow-sm">Lưu Thay Đổi</button></div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (isset($_SESSION['auth_status'])): ?>
        Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, icon: '<?= $_SESSION['auth_status'] ?>', title: '<?= $_SESSION['auth_message'] ?>' });
        <?php unset($_SESSION['auth_status'], $_SESSION['auth_message']); ?>
    <?php endif; ?>

    document.querySelectorAll('.btn-edit-product').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('e_id').value = this.dataset.id;
            document.getElementById('e_name').value = this.dataset.name;
            document.getElementById('e_price').value = this.dataset.price;
            document.getElementById('e_old_price').value = this.dataset.oldprice;
            document.getElementById('e_cat').value = this.dataset.cat;
            document.getElementById('e_brand').value = this.dataset.brand;
            document.getElementById('e_stock').value = this.dataset.stock;
            document.getElementById('e_desc').value = this.dataset.desc;
            document.getElementById('e_thumb_preview').src = this.dataset.thumb;
            new bootstrap.Modal(document.getElementById('editProductModal')).show();
        });
    });

    function deleteProduct(id) {
        Swal.fire({
            title: 'Xóa sản phẩm này?', text: "Hành động này không thể hoàn tác!", icon: 'error',
            showCancelButton: true, confirmButtonColor: '#e74c3c', confirmButtonText: 'Xóa ngay', cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = `public_entry.php?url=admin-product-delete&id=${id}`;
        });
    }
</script>