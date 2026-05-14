<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="mb-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="public_entry.php?url=news">Tin tức</a></li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($news['title']) ?></li>
                    </ol>
                </nav>
                <h1 class="fw-bold mb-3"><?= htmlspecialchars($news['title']) ?></h1>
                <p class="text-muted small">Ngày đăng: <?= date('d/m/Y', strtotime($news['created_at'])) ?> | Danh mục: <?= htmlspecialchars($news['category']) ?></p>
                <img src="<?= htmlspecialchars($news['image']) ?>" class="img-fluid rounded mb-4 w-100" style="max-height:500px; object-fit:cover;">
                <div class="content lh-lg">
                    <?= nl2br(htmlspecialchars($news['content'])) ?>
                </div>
            </article>

            <section class="comments-section bg-light p-4 rounded">
                <h4 class="fw-bold mb-4">Bình luận (<?= count($comments) ?>)</h4>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="public_entry.php?url=news/comment" method="POST" class="mb-4">
                        <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="3" placeholder="Chia sẻ ý kiến của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                <?php else: ?>
                    <p class="alert alert-info">Vui lòng <a href="public_entry.php?url=login">đăng nhập</a> để bình luận.</p>
                <?php endif; ?>

                <div class="comment-list">
                    <?php foreach($comments as $cmt): ?>
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <?= strtoupper(substr($cmt['fullname'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($cmt['fullname']) ?></h6>
                                <small class="text-muted"><?= date('H:i d/m/Y', strtotime($cmt['created_at'])) ?></small>
                                <p class="mb-0 mt-1"><?= htmlspecialchars($cmt['content']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</div>