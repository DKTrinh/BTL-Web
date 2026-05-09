<?php require_once '../app/views/layouts/header.php'; ?>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="d-inline-block badge-soft mb-3">Leading Environmental Technology</span>
                <h1 class="hero-title mb-4">Clean Air Through Advanced Flue Gas Technology</h1>
                <p class="text-secondary fs-5 mb-4 pe-lg-5">Cutting-edge emission control systems that deliver exceptional performance, regulatory compliance, and environmental sustainability for industrial operations worldwide.</p>
                <div>
                    <a href="#" class="btn btn-primary-custom btn-lg me-3 px-4 py-3">Explore Solutions</a>
                    <a href="#" class="btn btn-outline-dark btn-lg px-4 py-3 border-2 bg-white">Watch Demo</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1000&auto=format&fit=crop" alt="Industrial" class="hero-image">
                    <div class="floating-stat d-none d-md-block">
                        <h3 class="text-primary fw-bold mb-0">99.9%</h3>
                        <span class="text-secondary small">Cleaning Efficiency</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats-banner">
    <div class="container text-center">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <p class="stat-number">2,500+</p>
                <p class="stat-text">Installations Worldwide</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-number">99.9%</p>
                <p class="stat-text">Average Efficiency</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-number">15+</p>
                <p class="stat-text">Years Experience</p>
            </div>
            <div class="col-6 col-md-3">
                <p class="stat-number">24/7</p>
                <p class="stat-text">Technical Support</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title fs-1">Core Technologies</h2>
            <p class="text-secondary">Our comprehensive suite of proven emission control technologies delivers superior performance across all industrial applications.</p>
        </div>
        
        <div class="row g-4">
            <?php 
            $icons = ['bi-filter-square', 'bi-droplet', 'bi-thermometer-half', 'bi-recycle', 'bi-lightning', 'bi-cpu'];
            foreach($technologies as $index => $tech): 
                // Xử lý an toàn: Nếu không có cột efficiency, mặc định hiện 99.9%
                $efficiency = $tech['efficiency'] ?? '99.9%';
            ?>
            <div class="col-md-4">
                <div class="card tech-card h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="tech-icon">
                            <i class="bi <?= $icons[$index % count($icons)] ?>"></i>
                        </div>
                        <span class="text-primary fw-bold"><?= htmlspecialchars($efficiency) ?></span>
                    </div>
                    <h5 class="fw-bold mb-3"><?= htmlspecialchars($tech['name']) ?></h5>
                    <p class="text-secondary small mb-0"><?= htmlspecialchars($tech['description'] ?? 'Advanced environmental solution for modern industries.') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title fs-1">Success Stories</h2>
            <p class="text-secondary">Real-world results from our global installations demonstrating measurable environmental and operational improvements.</p>
        </div>

        <div class="row g-4">
            <?php foreach($stories as $index => $story): 
                // Cung cấp các giá trị mặc định để tránh lỗi
                $badge = $story['badge'] ?? 'Featured Case';
                $category = $story['category'] ?? 'Industry Solutions';
                
                // Mảng chứa các link ảnh dự phòng từ Unsplash để đảm bảo luôn có ảnh đẹp
                $fallbackImages = [
                    'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?q=80&w=600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?q=80&w=600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1504917595217-d4f3915f210e?q=80&w=600&auto=format&fit=crop'
                ];
                
                // Kiểm tra xem DB có ảnh hợp lệ không, nếu không lấy ảnh dự phòng
                $imgUrl = (!empty($story['image']) && filter_var($story['image'], FILTER_VALIDATE_URL)) 
                          ? $story['image'] 
                          : $fallbackImages[$index % count($fallbackImages)];
            ?>
            <div class="col-md-4">
                <div class="card story-card h-100 position-relative">
                    <span class="story-badge"><?= htmlspecialchars($badge) ?></span>
                    <img src="<?= htmlspecialchars($imgUrl) ?>" class="card-img-top" alt="Case Study">
                    <div class="card-body p-4 bg-light">
                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($story['title']) ?></h5>
                        <p class="text-primary small mb-3"><?= htmlspecialchars($category) ?></p>
                        <p class="text-secondary small mb-0"><?= htmlspecialchars(substr($story['content'] ?? 'Implemented successful solutions driving major reductions in emissions.', 0, 120)) ?>...</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section text-center">
    <div class="container">
        <h2 class="fw-bold mb-3 fs-1 text-white">Ready to Transform Your Emissions Control?</h2>
        <p class="mb-5 text-white-50">Get in touch with our experts to discuss your specific requirements and discover how our solutions can help you achieve your environmental goals.</p>
        
        <form class="d-flex justify-content-center mx-auto" style="max-width: 500px;">
            <input type="email" class="form-control form-control-lg me-2 border-0 shadow-sm" placeholder="Enter your email address" required>
            <button type="submit" class="btn btn-dark btn-lg px-4 fw-bold">Contact Us</button>
        </form>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>