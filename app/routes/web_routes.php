<?php
// app/routes/web_routes.php

return [
    // --- Các route có sẵn ---
    
    // Trang Giới thiệu (About Us) 
    'about' => [
        'controller' => 'AboutController',
        'action'     => 'index',
        'method'     => 'GET'
    ],

    // Trang Hỏi/đáp (FAQ) 
    'faq' => [
        'controller' => 'FaqController',
        'action'     => 'index',
        'method'     => 'GET'
    ],

    // Trang Chủ (Trống hoặc gõ chữ 'home')
    ''     => ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET'],
    'home' => ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET'],


    // --- KHAI BÁO THÊM ROUTE CHO TIN TỨC (NEWS) CHUẨN CÚ PHÁP ARRAY ---
    
    // 1. Danh sách tin tức (GET)
    'news' => [
        'controller' => 'NewsController',
        'action'     => 'index',
        'method'     => 'GET'
    ],
    
    // 2. Chi tiết tin tức (Dùng chung cho cả GET và POST bình luận nếu có)
    'news/detail' => [
        'controller' => 'NewsController',
        'action'     => 'detail',
        'method'     => ['GET', 'POST'] // Hỗ trợ cả 2 phương thức nếu file router của bạn cho phép mảng
    ]
    
    // CONTACT
    'contact' => [
        'controller' => 'ContactController',
        'action'     => 'index',
        'method'     => 'GET'
    ],

    // SAVE CONTACT
    'contact/save' => [
        'controller' => 'ContactController',
        'action'     => 'save',
        'method'     => 'POST'
    ]

];