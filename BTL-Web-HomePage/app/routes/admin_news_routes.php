<?php
// Admin News
$router->get('/admin/news',              'AdminNewsController@index');
$router->get('/admin/news/add',          'AdminNewsController@add');
$router->post('/admin/news/store',       'AdminNewsController@store');
$router->get('/admin/news/edit/{id}',    'AdminNewsController@edit');
$router->post('/admin/news/update/{id}', 'AdminNewsController@update');
$router->post('/admin/news/delete/{id}', 'AdminNewsController@delete');

// Admin Comments
$router->get('/admin/comments',                  'AdminCommentController@index');
$router->post('/admin/comments/status',          'AdminCommentController@updateStatus');
$router->post('/admin/comments/delete',          'AdminCommentController@delete');