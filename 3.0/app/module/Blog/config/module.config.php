<?php

return [
    'router' => [
        'routes' => [
            'blog' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => 'Blog\Controller\List',
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'single' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/:id',
                            'defaults' => [
                                'action' => 'single'
                            ],
                            'constraints' => ['id' => '\d+']
                        ]
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/:id/edit',
                            'defaults' => [
                                'controller' => 'Blog\Controller\EditPost',
                                'action' => 'edit'
                            ],
                            'constraints' => ['id' => '\d+']
                        ]
                    ],
                    'create' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/create',
                            'defaults' => [
                                'controller' => 'Blog\Controller\EditPost',
                                'action' => 'create'
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/:id/delete',
                            'defaults' => [
                                'controller' => 'Blog\Controller\DeletePost',
                                'action' => 'delete'
                            ]
                        ],
                        'constraints' => [
                            'id' => '\d+'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'invokables' => [
            //'Blog\Controller\List' => Controller\ListController::class
        ],
        'factories' => [
            'Blog\Controller\List' => 'Blog\\Factory\\ListControllerFactory',
            'Blog\Controller\EditPost' => 'Blog\\Factory\\EditPostControllerFactory',
            'Blog\Controller\DeletePost' => 'Blog\\Factory\\DeletePostControllerFactory'
        ]
    ],
    'service_manager' => [
        'invokables' => [
            //'Blog\Model\Post' => Blog\Model\Post::class,
        ],
        'factories' => [
            'Blog\Service\PostService' => Blog\Factory\PostServiceFactory::class,
            'Zend\Db\Adapter\Adapter'  => Zend\Db\Adapter\AdapterServiceFactory::class,
            'Zend\Form\FormElementManager' => Zend\Form\FormElementManagerFactory::class,
            'Blog\Mapper\PostMapperInterface'   => 'Blog\Factory\PostMapperFactory'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],

    'db' => array(
        'driver'         => 'Pdo',
        'username'       => 'XXXXXXX',
        'password'       => 'XXXXXXX',
        'dsn'            => 'mysql:dbname=zend;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
];