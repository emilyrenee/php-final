<?php

$router->get('', 'EmployeeController@viewAll');
$router->get('view', 'EmployeeController@viewEmployee');
$router->get('create', 'EmployeeController@viewCreate');
$router->post('create', 'EmployeeController@create');
$router->get('update', 'EmployeeController@viewEdit');
$router->post('update', 'EmployeeController@update');
$router->post('delete', 'EmployeeController@delete');
