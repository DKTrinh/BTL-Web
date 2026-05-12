<div class="main-content-inner py-5" style="background: #f0f4f8;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Hệ thống Kiểm duyệt FAQ</h2>
            <div class="badge bg-warning text-dark p-2 px-3">Đang chờ: <?= $countPending ?> câu hỏi</div>
        </div>

        <div class="y2k-container shadow-lg border-0 bg-white" style="border-radius: 25px; overflow: hidden;">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="ps-4">Mã REQ</th>
                        <th>Chủ đề</th>
                        <th>Nội dung câu hỏi</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($faqs as $faq): ?>
                    <tr>
                        <td class="ps-4 text-muted">#<?= $faq['f_id'] ?></td>
                        <td><span class="badge bg-info-subtle text-info border border-info-subtle px-2"><?= htmlspecialchars($faq['title']) ?></span></td>
                        <td style="max-width: 400px;" class="text-truncate"><?= htmlspecialchars($faq['question']) ?></td>
                        <td class="text-center py-3">
                            <a href="public_entry.php?url=admin/faq/edit&id=<?= $faq['f_id'] ?>" 
                               class="btn btn-sm btn-primary fw-bold rounded-pill px-3 me-2">
                                <i class="bi bi-pencil-square me-1"></i> Trả lời & Duyệt
                            </a>
                            
                            <a href="public_entry.php?url=admin/faq/delete&id=<?= $faq['f_id'] ?>" 
                               class="btn btn-sm btn-outline-danger fw-bold rounded-pill px-3"
                               onclick="return confirm('Bạn chắc chắn muốn xóa bỏ câu hỏi này?')">
                                <i class="bi bi-trash me-1"></i> Xóa bỏ
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>