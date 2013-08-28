<?php

$securityConfig = array(
    'firewalls' => array(),
    'access_control' => array(
        array('path' => '^/signals', 'role' => 'ROLE_CUSTOMER'),
        array('path' => '^/traders', 'role' => 'ROLE_CUSTOMER'),
    ),
    'providers' => array(
        'webservice' => array('id' => 'user.security.user_provider')
    ),
    'encoders' => array(
        'Raeting\UserBundle\Security\User' => array(
            'algorithm' => 'sha1',
            'encode_as_base64' => false,
            'iterations' => 1,
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
