<?php

/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */
return [
    'db' => [
        'driver' => 'pdo_mysql',
        'hostname' => '127.0.0.1',
        'database' => 'bd_nosocomio',
        'username' => 'root',
        'password' => 'root',
        'port' => '3306',
        'options' => ['buffer_results' => true],
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\''
        ]
    ],
    'mongodb' => array(
        'db' => array(
            'dbname' => 'admin',
            'host' => '127.0.0.1',
            'port' => '27017',
            'username' => '',
            'password' => '',
            'connectTimeoutMS' => -1
        )
    ),
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ]
    ],
    'cdn' => [
        'link_helper' => [
            'enabled' => true,
        ],
        'statics' => array(
            'scheme' => NULL,
            'host' => 'api-nosocomio.local',
            'port' => NULL,
        ),
        'elements' => array(
            'scheme' => NULL,
            'host' => 'api-nosocomio.local',
            'port' => NULL,
        ),
        'file_lastCommit' => ROOT_PATH . 'last_commit',
    ],
];
