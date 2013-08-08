<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href="<?= $view['assets']->getUrl('assets/css/bootstrap.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('assets/css/raeting.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('assets/css/bootstrap-responsive.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript">
            var ROOT_URL  = '<?= $view['request']->getRootUrl(); ?>';
        </script>
        <script src="<?= $view['assets']->getUrl('assets/js/jquery-1.10.2.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    </head>
    <body>
        <div class="main-wrap">
        <? $view['slots']->output('header_row') ?>
        <? $view['slots']->output('body') ?>
        </div>
        <hr>

        <div class="footer">
            <div class="copyright">
                Copyright &copy; RAETING.com 2013. All rights reserved.
            </div>
        </div>
    </body>
</html>
