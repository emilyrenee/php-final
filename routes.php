<?php

$router->get('', 'EmployeeController@index'); // return all employees
$router->get('create', 'EmployeeController@viewCreateEmployee'); 
$router->post('create', 'EmployeeController@createEmployee');
// $router->get('/employee/{$id}/view', function() {
//     // return employee
// });
// $router->get('/employee/{$id}/create', function() {
//     //
// });
// $router->get('/employee/{$id}/update', function() {
//     //
// });