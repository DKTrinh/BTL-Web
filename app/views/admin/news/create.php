<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Thêm Bài viết Mới</h4>
                    <form action="public_entry.php?url=admin/news/store" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Danh mục</label>
                                <input type="text" name="category" class="form-control" placeholder="Ví dụ: Công nghệ">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Badge (Ghi chú nhỏ)</label>
                                <input type="text" name="badge" class="form-control" placeholder="Ví dụ: Tin mới">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đường dẫn ảnh (URL)</label>
                            <input type="text" name="image" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Nội dung bài viết</label>
                            <textarea name="content" class="form-control" rows="10" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-5 py-2">Lưu bài viết</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>