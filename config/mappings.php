<?php
use Ramsey\Uuid\Doctrine\UuidGenerator;

return [
    'Notepad\Domain\Model\Notepad\Notepad' => [
        'type'   => 'entity',
        'table'  => 'notepad',
        'id'     => [
            'id' => [
                'type'     => 'NotepadId',
                'column' => 'id'
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string'
            ],
            'userId' => [
                'type' => 'uuid'
            ]
        ],
        'manyToOne' => [
            'user' => [
                'targetEntity' =>  'Notepad\Domain\Model\User\User',
                'inversedBy' => 'notepads',
                'joinColumn' => [
                    'name' => 'user_id',
                    'referencedColumnName'=> 'id'
                ]

            ]
        ]
    ],
    'Notepad\Domain\Model\User\User' => [
        'type'   => 'entity',
        'table'  => 'users',
        'id'     => [
            'id' => [
                'type'     => 'UserId',
                'column' => 'id'
            ],
        ],
        'fields' => [
            'name' => [
                'type' => 'string'
            ],
            'email' => [
                'type' => 'string'
            ]
        ],
        'oneToMany' => [
                'notepads' => [
                    'orphanRemoval' => 'true',
                    'cascade' => ["all"],
                    'targetEntity' =>  'Notepad\Domain\Model\Notepad\Notepad',
                    'mappedBy'=> 'user'
                ]
            ]
        ]
    ];
