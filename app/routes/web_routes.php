<?php
// app/routes/web_routes.php

return [
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

    // Bạn có thể thêm các route mặc định khác ở đây
    ''     => ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET'],
    'home' => ['controller' => 'HomeController', 'action' => 'index', 'method' => 'GET'],
];