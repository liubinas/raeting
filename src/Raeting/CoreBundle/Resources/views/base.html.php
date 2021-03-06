<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta charset="utf-8"/>
        <title>Raeting.com</title>
        <link rel="shortcut icon" href="<?= $view['assets']->getUrl('favicon.ico') ?>">
        <link rel="apple-touch-icon" href="<?= $view['assets']->getUrl('apple-touch-icon.png') ?>" />
        <link href="<?= $view['assets']->getUrl('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $view['assets']->getUrl('css/main.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <? if(isset($hideSidebar)): ?>
            <link href="<?= $view['assets']->getUrl('css/title.css') ?>" rel="stylesheet" type="text/css" media="all" />
        <? endif; ?>
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
        <script src="<?= $view['assets']->getUrl('js/libs/underscore.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/libs/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/libs/jquery.slimscroll.horizontal.min.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/libs/breakpoints.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/app.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/app_template.js') ?>" type="text/javascript"></script>
        <script src="<?= $view['assets']->getUrl('js/raeting.js') ?>" type="text/javascript"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
                <script src="<?= $view['assets']->getUrl('js/libs/html5shiv.js') ?>" type="text/javascript"></script>
	<![endif]-->
    </head>
    <body
        <? if (isset($hideSidebar)): ?>
            class="page-aqua visible-body titlepage breakpoint-1200"
        <? endif;?>
        data-controller="<?= $view['request']->getParameter('controllerName')?>"
        data-action="<?= $view['request']->getParameter('actionName')?>"
        <? $view['slots']->output('body_attr') ?>>

        <header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void();" title=""><i class="icon-reorder"></i></a></li>
			</ul>

			<!-- Logo -->
			<a class="navbar-brand" href="<?=$view['router']->generate('home')?>">
				<img class="logo-img" src="<?= $view['assets']->getUrl('img/logo.png'); ?>" alt="logo" />
                                <span class="beta">beta</span>
			</a>
			<!-- /logo -->
            <ul class="nav navbar-nav navbar-right hidden-xs hidden-sm">
                <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) :
                    $user = $app->getUser();
                ?>
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-male"></i>
                        <span class="username"><?= $user->getFirstname().' '.$user->getLastname()?></span>
                        <i class="icon-caret-down small"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=$view['router']->generate('trader_show', array('slug' => $user->getSlug() )) ?>"><i class="icon-user"></i> My Profile</a></li>
                        <li><a href="<?=$view['router']->generate('user.profile.edit') ?>"><i class="icon-pencil"></i> Edit Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?=$view['router']->generate('estinacmf_user.logout') ?>"><i class="icon-key"></i> Log Out</a></li>
                    </ul>
                </li>
            <? else: ?>
                <li><a href="<?= $view['router']->generate('estinacmf_user.security.login'); ?>">Login</a></li>
            <? endif; ?>
            </ul>
		</div>
		<!-- /top navigation bar -->
	</header> <!-- /.header -->
            <? if(!isset($hideSidebar)): ?>
                <div id="sidebar" class="sidebar-fixed">
			<div id="sidebar-content">
                <ul id="nav">

                    <li class="open">
                        <a href="javascript:void(0);">
                            <i class="icon-edit"></i>
                            Analysts
                            <i class="arrow icon-angle-left"></i>
                        </a>
                        <ul class="sub-menu" style="display: block;">
                            <li<? $view['slots']->output('menuAnalystsActive') ?>>
                                <a href="<?= $view['router']->generate('analyst'); ?>">
                                <i class="icon-list"></i>
                                Top
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="open">
                        <a href="javascript:void(0);" onclick="return false;">
                            <i class="icon-edit"></i>
                            Recommendations
                            <i class="arrow icon-angle-left"></i>
                        </a>
                        <ul class="sub-menu" style="display: block;">
                            <li<? $view['slots']->output('menuAnalysisActive') ?>>
                                <a href="<?= $view['router']->generate('analysis'); ?>">
                                <i class="icon-list"></i>
                                Latest
                                </a>
                            </li>
                        </ul>
                    </li>

                    <? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) :
                        $user = $app->getUser();
                    ?>
                        <li class="open">
                            <a href="javascript:void(0);">
                                <i class="icon-edit"></i>
                                My raeting
                                <i class="arrow icon-angle-left"></i>
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li<? $view['slots']->output('menuProfileActive') ?>>
                                    <a href="<?=$view['router']->generate('trader_show', array('slug' => $user->getSlug() )) ?>">
                                    <i class="icon-user"></i>
                                    Profile
                                    </a>
                                </li>
                                <li<? $view['slots']->output('menuProfileEditActive') ?>>
                                    <a href="<?=$view['router']->generate('user.profile.edit') ?>">
                                    <i class="icon-pencil"></i>
                                    Edit profile
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <? endif; ?>
                </ul>
			</div>
			<div id="divider" class="resizeable"></div>
		</div>
		<!-- /Sidebar -->
        <? endif; ?>
        <? if (!isset($hideSidebar)): ?>
            <div id="content">
                <div class="container">
                    <? $view['slots']->output('crumbs') ?>
                    <div class="page-header">
                        <div class="page-title">
                            <? $view['slots']->output('header_row') ?>
                        </div>
                    </div>
                    <? $view['slots']->output('content') ?>
                </div>
                <!-- /.container -->
            </div>
        <? else: ?>
            <? $view['slots']->output('content') ?>
        <? endif; ?>
        <footer>
                <span>Copyright &copy; RAETING.com 2014. All rights reserved.</span>
        </footer>
    </body>
</html>
