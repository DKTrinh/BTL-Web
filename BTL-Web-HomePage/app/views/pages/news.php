<section class="news-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Cập nhật mới nhất</h6>
            <h2 class="display-5 fw-bold mb-3">Tin tức Công nghệ & Môi trường</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Khám phá những đột phá mới nhất trong công nghệ xử lý khí thải và các giải pháp bảo vệ hành tinh của chúng ta.
            </p>
        </div>

        <div class="search-box mb-5">
            <form action="public_entry.php" method="GET" class="row justify-content-center g-2">
                <input type="hidden" name="url" value="news">
                <div class="col-md-5 col-8">
                    <input type="text" name="q" class="form-control form-control-lg shadow-sm" 
                           placeholder="Nhập tên bài viết cần tìm..." 
                           value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
                </div>
                <div class="col-md-1 col-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <?php if (!empty($data['newsList'])): ?>
                <?php foreach ($data['newsList'] as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="position-relative">
                                <img src="<?= htmlspecialchars($item['image'] ?? 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b') ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($item['title']) ?>" 
                                     style="height: 240px; object-fit: cover;">
                                     
                                <?php if (!empty($item['badge'])): ?>
                                    <span class="position-absolute top-0 start-0 badge bg-primary m-3 px-3 py-2 shadow">
                                        <?= htmlspecialchars($item['badge']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-primary fw-bold text-uppercase">
                                        <?= htmlspecialchars($item['category'] ?? 'Công nghệ') ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                                    </small>
                                </div>
                                
                                <h5 class="card-title mb-3 fw-bold line-clamp-2">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h5>
                                
                                <p class="card-text text-muted mb-0">
                                    <?= mb_substr(strip_tags($item['content']), 0, 110, 'UTF-8') ?>...
                                </p>
                            </div>
                            
                            <div class="card-footer bg-white border-0 p-4 pt-0">
                                <hr class="my-3 opacity-10">
                                <a href="public_entry.php?url=news/detail&id=<?= $item['id'] ?>" class="btn-read-more text-decoration-none fw-bold">
                                    Đọc tiếp <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-journal-x text-muted" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    <h4 class="text-muted">Rất tiếc, chúng tôi không tìm thấy bài viết nào.</h4>
                    <?php if (!empty($data['keyword'])): ?>
                        <a href="public_entry.php?url=news" class="btn btn-outline-primary mt-3">Quay lại tất cả tin tức</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (($data['totalPages'] ?? 1) > 1): ?>
            <nav class="mt-5 pt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($data['page'] ?? 1) <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="public_entry.php?url=news&q=<?= urlencode($data['keyword'] ?? '') ?>&page=<?= ($data['page'] ?? 1) - 1 ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                        <li class="page-item <?= ($data['page'] ?? 1) == $i ? 'active' : '' ?>">
                            <a class="page-link" href="public_entry.php?url=news&q=<?= urlencode($data['keyword'] ?? '') ?>&page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($data['page'] ?? 1) >= $data['totalPages'] ? 'disabled' : '' ?>">
                        <a class="page-link" href="public_entry.php?url=news&q=<?= urlencode($data['keyword'] ?? '') ?>&page=<?= ($data['page'] ?? 1) + 1 ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>

<style>
/* Style riêng cho trang News */
.news-section { min-height: 80vh; }
.card { transition: all 0.3s ease; }
.card:hover { transform: translateY(-8px); box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 3rem; }
.btn-read-more { color: #2563eb; transition: all 0.2s; }
.btn-read-more:hover { color: #1d4ed8; padding-left: 5px; }
.pagination .page-link { color: #4b5563; border: none; margin: 0 5px; border-radius: 8px; padding: 10px 18px; background-color: #f8f9fa; }
.pagination .page-item.active .page-link { background-color: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3); }
</style>