<?php

$securityConfig = array(
    'firewalls' => array(),
    'access_control' => array(
        array('path' => '^/admin', 'role' => 'ROLE_ADMIN')
    ),
    'providers' => array(
        'webservice' => array('id' => 'user.security.user_provider')
    ),
    'encoders' => array(
        'Raeting\UserBundle\Security\User' => array(
            'algorithm' => 'sha512',
            'encode_as_base64' => false,
            'iterations' => 1000,
        )
    ),
);

    $securityConfig['firewalls']['secured_area'] = array(
        'pattern' => '^/',
        'anonymous' => array(),
        'form_login' => array(
            'login_path' => '/login',
            'check_path' => '/login_check',
        ),
        'logout' => array(
            'path' => '/logout',
            'target' => '/'
        ),
        'remember_me' => array(
            'key' => '%secret%',
            'lifetime' => 3600,
            'path' => '/',
            'domain' => '',
        )
    );

$container->loadFromExtension('security', $securityConfig);
