<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta charset="utf-8"/>
        <title>Raeting.com</title>
        <link href="<?= $view['assets']->getUrl('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/main.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/plugins.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/responsive.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/icons.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/login.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/my.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/fontawesome/font-awesome.min.css') ?>" rel="stylesheet"/>
        <!--[if IE 7]>
                <link href="<?= $view['assets']->getUrl('css/fontawesome/font-awesome-ie7.min.css') ?>" rel="stylesheet"/>
	<![endif]-->

	<!--[if IE 8]>
                <link href="<?= $view['assets']->getUrl('css/ie8.css') ?>" rel="stylesheet"/>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
        <link href="<?= $view['assets']->getUrl('css/jquery-ui-1.10.3.custom.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <script type="text/javascript">
            var ROOT_URL  = '<?= $view['request']->getRootUrl(); ?>';
        </script>
        <script src="<?= $view['assets']->getUrl('js/jquery-1.10.2.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/jquery-ui-1.10.3.custom.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/app.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/app_template.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/raeting.js') ?>" type="text/javascript"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
                <script src="<?= $view['assets']->getUrl('js/libs/html5shiv.js') ?>" type="text/javascript"></script>
	<![endif]-->
    </head>
    <body data-controller="<?= $view['request']->getParameter('controllerName')?>" data-action="<?= $view['request']->getParameter('actionName')?>" <? $view['slots']->output('body_attr') ?>>
        <header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void();" title=""><i class="icon-reorder"></i></a></li>
			</ul>

			<!-- Logo -->
			<a class="navbar-brand" href="<?=$view['router']->generate('home')?>">
				<img src="<?= $view['assets']->getUrl('img/logo.png'); ?>" alt="logo" />
			</a>
			<!-- /logo -->
		</div>
		<!-- /top navigation bar -->
	</header> <!-- /.header -->
        <div id="container" class="fixed-header">
		<div id="sidebar" class="sidebar-fixed">
			<div id="sidebar-content">
                            <ul id="nav">
                                <? $view['slots']->output('menu') ?>
                            </ul>
                            <div class="sidebar-title">
                                    <span>Copyright &copy; RAETING.com 2013.<br/> All rights reserved.</span>
                            </div>
			</div>
			<div id="divider" class="resizeable"></div>
		</div>
		<!-- /Sidebar -->

		<div id="content">
			<div class="container">
                            <? $view['slots']->output('crumbs') ?>
                            <div class="page-header">
                                    <div class="page-title">
                                            <h3><? $view['slots']->output('header_row') ?></h3>
                                    </div>
                            </div>
                            <? $view['slots']->output('content') ?>
                        </div>
			<!-- /.container -->
		</div>
	</div>
    </body>
</html>
