<div class="container my-5 py-5 text-center">
    <h1 class="display-4 fw-bold text-info">FAQs</h1>
    <p class="text-muted">Các câu hỏi thường gặp về hệ thống CleanTech.</p>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion shadow-sm" id="accordionCleanTech">
                <?php if (isset($data['faqs']) && !empty($data['faqs'])): ?>
                    <?php foreach ($data['faqs'] as $index => $faq): ?>
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                            <h2 class="accordion-header" id="heading-<?= $index ?>">
                                <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?> fw-bold bg-white text-dark" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse-<?= $index ?>" 
                                        aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" 
                                        aria-controls="collapse-<?= $index ?>">
                                    <span class="text-info me-2">#<?= $index + 1 ?></span>
                                    <?= htmlspecialchars($faq['question']) ?> </button>
                            </h2>
                            <div id="collapse-<?= $index ?>" 
                                 class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" 
                                 aria-labelledby="heading-<?= $index ?>" 
                                 data-bs-parent="#accordionCleanTech">
                                <div class="accordion-body bg-white border-top text-secondary" style="line-height: 1.6;">
                                    <?= nl2br(htmlspecialchars($faq['answer'])) ?> </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-light text-center border">
                        Hiện chưa có câu hỏi nào trong danh mục này.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Tùy chỉnh dấu ^ (mũi tên) để trông chuyên nghiệp hơn */
.accordion-button::after {
    background-size: 1rem;
    transition: transform 0.3s ease;
}

/* Hiệu ứng khi di chuột qua câu hỏi */
.accordion-item:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.accordion-button:not(.collapsed) {
    color: #0dcaf0 !important; /* text-info */
    background-color: #f8f9fa !important;
    box-shadow: none;
}
</style>