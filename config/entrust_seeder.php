<?php

return [
    'role_structure' => [
        'admin' => [
            'users' => 'c,r,u,d',
            'admin' => 'c,r,u,d',
            'profile' => 'r,d'
        ],
        'customer' => [
            'profile' => 'r,u'
        ],
    ],
    'user_roles' => [
        'admin' => [
            ['name' => "Admin", "email" => "admin@gmail.com", "password" => 'password'],
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
