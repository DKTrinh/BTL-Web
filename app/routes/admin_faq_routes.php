<?php
// app/routes/admin_faq_routes.php

return [
    // Hiển thị danh sách FAQ (có phân trang) [cite: 78, 84]
    'admin/faq' => [
        'controller' => 'AdminFaqController',
        'action'     => 'index',
        'method'     => 'GET'
    ],

    // Giao diện thêm câu hỏi mới
    'admin/faq/create' => [
        'controller' => 'AdminFaqController',
        'action'     => 'create',
        'method'     => 'GET'
    ],

    // Xử lý lưu câu hỏi vào Database (Server-side validation) [cite: 63]
    'admin/faq/store' => [
        'controller' => 'AdminFaqController',
        'action'     => 'store',
        'method'     => 'POST'
    ],

    // Giao diện chỉnh sửa câu hỏi
    'admin/faq/edit' => [
        'controller' => 'AdminFaqController',
        'action'     => 'edit',
        'method'     => 'GET'
    ],

    // Xử lý cập nhật câu hỏi
    'admin/faq/update' => [
        'controller' => 'AdminFaqController',
        'action'     => 'update',
        'method'     => 'POST'
    ],

    // Xóa câu hỏi
    'admin/faq/delete' => [
        'controller' => 'AdminFaqController',
        'action'     => 'delete',
        'method'     => 'POST' // Nên dùng POST để bảo mật hơn
    ],
];