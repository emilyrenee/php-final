<?php
require('./app/Router.php');
require('./app/Request.php');


require Router::load('routes.php')
    ->get(Request::uri());

// $router = new Router(new Request);

// var_dump('Here!!!!!!');

// $router->get('/', function() {
//     // return all employees
//     return '<h1>HEllo</h1>';
// });

// $router->get('/employee/{$id}/view', function() {
//     // return employee
// });

// $router->get('/employee/{$id}/create', function() {
//     //
// });

// $router->get('/employee/{$id}/update', function() {
//     //
// });