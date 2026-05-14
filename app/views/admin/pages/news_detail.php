<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <article>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="public_entry.php?url=news">Tin tức</a></li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($news['title']) ?></li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($news['title']) ?></h1>
                <div class="text-muted mb-4">
                    <i class="bi bi-calendar3 me-2"></i> <?= date('d/m/Y', strtotime($news['created_at'])) ?>
                    <span class="badge bg-primary ms-3"><?= htmlspecialchars($news['category'] ?? 'Công nghệ') ?></span>
                </div>
                <img src="<?= htmlspecialchars($news['image']) ?>" class="img-fluid rounded-4 mb-4 shadow-sm w-100" style="max-height: 450px; object-fit: cover;">
                <div class="news-content fs-5 leading-relaxed">
                    <?= nl2br(htmlspecialchars($news['content'])) ?>
                </div>
            </article>

            <hr class="my-5">

            <section id="comments-section">
                <h4 class="fw-bold mb-4">Bình luận bài viết</h4>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="public_entry.php?url=news/comment" method="POST" class="mb-4">
                        <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
                        <textarea name="content" class="form-control mb-2" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                <?php else: ?>
                    <p class="alert alert-info">Vui lòng <a href="public_entry.php?url=login">đăng nhập</a> để để lại bình luận.</p>
                <?php endif; ?>

                <div class="list-group">
                    <?php if(!empty($comments)): ?>
                        <?php foreach($comments as $cmt): ?>
                            <div class="list-group-item border-0 border-bottom py-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($cmt['fullname']) ?></h6>
                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($cmt['created_at'])) ?></small>
                                </div>
                                <p class="mb-0 text-secondary"><?= htmlspecialchars($cmt['content']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted italic">Chưa có bình luận nào cho bài viết này.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</div>