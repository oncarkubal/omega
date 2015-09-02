<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'controllers'=>array(
        'invokables'=>array(
            'Omega\Controller\Index'=>'Omega\Controller\IndexController'
        ),
    ),
    'router'=>array(
        'routes'=>array(
            'omega'=>array(
                'type'=>'Literal',
                'options'=>array(
                    'route'=>'/omega',
                    'defaults'=>array(
                        '__NAMESPACE__'=>'Omega\Controller',
                        'controller'=>'Index',
                        'action'=>'index',
                    ),
                ),
                'may_terminate'=>true,
                'child_routes'=>array(
                    'default'=>array(
                        'type'=>'Segment',
                        'options'=>array(
                            'route'=>'/[:controller[/:action[/:id]]]',
                            'constraints'=>array(
                                'controller'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'=>'[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'=>'[0-9]*',
                            ),
                            'defaults'=>array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager'=>array(
        'template_path_stack'=>array(
            'omega'=>__DIR__ . '/../view',
        ),
    ),
);
