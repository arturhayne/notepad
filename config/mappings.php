<?php
use Ramsey\Uuid\Doctrine\UuidGenerator;

return [
    'Notepad\Domain\Model\User\User' => [
        'type'   => 'entity',
        'table'  => 'users',
        'id'     => [
            'id' => [
                'type'     => 'uuid'
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string'
            ],
            'email' => [
                'type' => 'string'
            ],
        ]
    ]
];