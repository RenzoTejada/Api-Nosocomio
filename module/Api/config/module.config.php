<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\NosocomioRest' => 'Api\Controller\NosocomioRestController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
        )
    ),
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/api',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Api\Controller',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9-]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'nosocomio-rest' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/nosocomio-rest/[:id]',
                            'constraints' => array(
                                'id' => '[0-9-]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Api\Controller',
                                'controller' => 'NosocomioRest'
                            ),
                        ),
                    ),

                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
