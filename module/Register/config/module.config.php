<?php

return array(
    'session' => array(
        'remember_me_seconds' => 2419200,
        'use_cookies' => true,
        'cookie_httponly' => true,
    ),
    'storage' => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Register\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

            'register' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/register',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Register\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Register\Controller\Index' => 'Register\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
);
