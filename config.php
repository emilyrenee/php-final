<?php

return [
    'database' => [
        'name' => 'modules',
        'username' => 'modules',
        'password' => 'secret',
        'connection' => 'mysql:host=mysql:3306',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
