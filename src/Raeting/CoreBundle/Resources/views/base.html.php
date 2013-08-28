<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Raeting.com</title>
        <link href="<?= $view['assets']->getUrl('css/bootstrap.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/raeting.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/bootstrap-responsive.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/jquery-ui-1.10.3.custom.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript">
            var ROOT_URL  = '<?= $view['request']->getRootUrl(); ?>';
        </script>
        <script src="<?= $view['assets']->getUrl('js/jquery-1.10.2.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/jquery-ui-1.10.3.custom.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/app.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/raeting.js') ?>" type="text/javascript"></script>
    </head>
    <body data-controller="krabas" data-action="labas">
        <div class="main-wrap">
            <div class="head">
                <ul class="nav nav-pills pull-right">
                  <? $view['slots']->output('menu') ?>
                </ul>
                <h3>
                    <a href="<?=$view['router']->generate('home')?>">
                    <img src="<?= $view['assets']->getUrl('img/logo.png'); ?>" alt="raeting logo" id="logo" width="" height="" /></a>
                </h3>
            </div>
        <? $view['slots']->output('header_row') ?>
        <? $view['slots']->output('content') ?>
        </div>
        <hr>

        <div class="footer">
            <div class="copyright">
                Copyright &copy; RAETING.com 2013. All rights reserved.
            </div>
        </div>
    </body>
</html>
