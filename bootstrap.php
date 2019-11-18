<?php

use App\Core\App;
use App\Core\{QueryBuilder, Connection};

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(
    Connection::makeConnection(App::get('config')['database'])
));
