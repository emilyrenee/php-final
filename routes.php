<?php

$router->get('', 'EmployeeController@index'); // return all employees
$router->get('create', 'EmployeeController@viewCreateEmployee'); 
$router->post('create', 'EmployeeController@createEmployee');
$router->get('view', 'EmployeeController@employee');
// $router->get('/employee/{$id}/create', function() {
//     //
// });
// $router->get('/employee/{$id}/update', function() {
//     //
// });