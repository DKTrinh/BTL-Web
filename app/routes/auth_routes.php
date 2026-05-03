// app/routes/auth_routes.php
<?php
// app/routes/auth_routes.php

/**
 * Các route cho phần Authentication
 * Controller: AuthController.php
 */

// app/routes/auth_routes.php
$router->add('GET', 'login', 'AuthController@showLogin');
$router->add('POST', 'login', 'AuthController@login');
$router->add('GET', 'register', 'AuthController@showRegister');
$router->add('POST', 'register', 'AuthController@register');