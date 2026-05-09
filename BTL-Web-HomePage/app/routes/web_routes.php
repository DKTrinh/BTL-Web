$router->get('/news',        'NewsController@index');
$router->get('/news/{slug}', 'NewsController@detail');
$router->post('/news/{slug}','NewsController@detail');