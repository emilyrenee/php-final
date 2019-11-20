<?php

require('../vendor/autoload.php');
require('../bootstrap.php');

use App\Core\Router;
use App\Core\Request;

Router::load('../routes.php')
    ->direct(Request::uri(), Request::method());
