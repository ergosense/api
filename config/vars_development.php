<?php
use function DI\add;

return [
    'settings.migrations' => './migrations',
    'settings.jwt_key' => 'testkey',
    'settings.pdo.driver' => 'mysql',
    'settings.pdo.host' => 'localhost',
    'settings.pdo.db' => 'test',
    'settings.pdo.user' => 'root',
    'settings.pdo.password' => null
];
