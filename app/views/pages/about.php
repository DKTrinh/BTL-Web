<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h2 class="text-center mb-4 fw-bold">Tìm hiểu về chúng tôi</h2>
            
            <div class="accordion accordion-flush shadow-sm border rounded" id="aboutAccordion">
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            <i class="fas fa-info-circle me-2 text-info"></i> Tổng quan về doanh nghiệp
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#aboutAccordion">
                        <div class="accordion-body text-secondary">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            <i class="fas fa-eye me-2 text-info"></i> Sứ mệnh và Tầm nhìn
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                        <div class="accordion-body text-secondary">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            <i class="fas fa-star me-2 text-info"></i> Giá trị cốt lõi
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                        <div class="accordion-body text-secondary">
                            <ul>
                                <li><strong>Chất lượng:</strong> Lorem ipsum dolor sit amet.</li>
                                <li><strong>Sáng tạo:</strong> Consectetur adipiscing elit.</li>
                                <li><strong>Tận tâm:</strong> Sed do eiusmod tempor incididunt.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                            <i class="fas fa-history me-2 text-info"></i> Lịch sử hình thành
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#aboutAccordion">
                        <div class="accordion-body text-secondary">
                            At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* CSS để nút toggle nhìn mượt hơn */
.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}
.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #0dcaf0;
}
</style>