<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Quản lý Tin tức</h3>
        <a href="public_entry.php?url=admin/news/create" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm bài viết</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="public_entry.php" method="GET" class="mb-4 row g-2">
                <input type="hidden" name="url" value="admin/news">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Tìm bài viết..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Tìm kiếm</button>
                </div>
            </form>

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Ngày đăng</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($newsList as $item): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded"></td>
                        <td class="fw-bold"><?= htmlspecialchars($item['title']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= date('d/m/Y', strtotime($item['created_at'])) ?></td>
                        <td class="text-center">
                            <a href="public_entry.php?url=admin/news/delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa bài viết này?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>