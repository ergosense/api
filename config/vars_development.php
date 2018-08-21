<?php
use function DI\add;

return [
    'settings' => add([
        'migrations' => './migrations/',
        'jwt_key' => 'testkey',
        'pdo' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'db' => 'test',
            'user' => 'root',
            'password' => null
        ]
    ])
];
