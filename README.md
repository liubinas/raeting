INSTALL
=======

    curl -s http://getcomposer.org/installer | php
    php composer.phar install
    chmod 777 app/cache app/logs

CONFIGURE
========

1) nano /etc/hosts
    127.0.0.1 raeting.localhost
2) Apache vhost:
Change $ENV to your enviroment name.
<VirtualHost *>
        ServerName raeting.localhost
        DocumentRoot /Users/$ENV/Sites/raeting/web
        <Directory /Users/$ENV/Sites/raeting/web>
            Options -Indexes +FollowSymLinks
            AllowOverride All
            setenv SYMFONY_ENV $ENV
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*) app_dev.php [QSA,L]
    </Directory>
</VirtualHost>
3) Add your $ENV to app/AppKernel.php 
  if (in_array($this->getEnvironment(), array($ENV));


Migrations:

migrate: app/console doctrine:migrations:migrate

load fixtures: app/console estina:fixtures:load