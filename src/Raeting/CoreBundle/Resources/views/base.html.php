<!doctype html>
<head>

    <meta charset="utf-8"/>
    
    <? $view['slots']->output('meta') ?>
    <meta name="viewport" content="width=990" />
    <link href="<?= $view['assets']->getUrl('css/style.css') ?><?= (null !== $view['config']->get('css_version')) ? '?'.$view['config']->get('css_version'):'' ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= $view['assets']->getUrl('css/jquery-ui.custom.css') ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= $view['assets']->getUrl('css/jquery.ui.selectmenu.css') ?>" rel="stylesheet" type="text/css" media="all" />
    
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <meta name="google-site-verification" content="<?=$view['config']->get('google.verify');?>" />

    <script src="<?= $view['assets']->getUrl('js/vendor/jquery-1.8.2.min.js') ?>" type="text/javascript"></script>
    
    <script src="<?= $view['assets']->getUrl('js/vendor/jquery-ui-1.9.1.custom.min.js') ?>" type="text/javascript"></script>
    
    <script src="<?= $view['assets']->getUrl('js/vendor/modernizr.js') ?>" type="text/javascript"></script>
    
    <script src="<?= $view['assets']->getUrl('js/vendor/jquery.ui.selectmenu.js') ?>" type="text/javascript"></script>
    <script src="<?= $view['assets']->getUrl('js/vendor/custom_checkboxes.js') ?>" type="text/javascript"></script>

    <script src="<?= $view['assets']->getUrl('js/vendor/i18n/jquery.ui.datepicker-'.$view['request']->getCharset().'.js') ?>" type="text/javascript"></script>
    
    <script type="text/javascript">
        var ROOT_URL  = '<?= $view['request']->getRootUrl(); ?>';
    </script>
    <script src="<?= $view['assets']->getUrl('js/core.js') ?><?= (null !== $view['config']->get('js_version')) ? '?' . $view['config']->get('js_version') : '' ?>" type="text/javascript"></script>
    <script type="text/javascript">
        App.Config.language = '<?= $view['request']->getCharset(); ?>';
        App.Config.social = {
            facebook_app_id : '<?= (null !== $view['config']->get('facebook.app_id')) ? $view['config']->get('facebook.app_id'):'' ?>',
            facebook_connect_url : '<?= (null !== $view['config']->get('facebook.connect_url.' . $view['request']->getParameter('language'))) ? $view['config']->get('facebook.connect_url.' . $view['request']->getParameter('language')):'' ?>',
            plusone_language : '<?= (null !== $view['config']->get('plusone.language.' . $view['request']->getParameter('language'))) ? $view['config']->get('plusone.language.' . $view['request']->getParameter('language')):'' ?>',
            weibo_app_key : '<?= (null !== $view['config']->get('weibo.app_key')) ? $view['config']->get('weibo.app_key'):'' ?>'
        }
    </script>
    <? if (file_exists('../web/js/' . $view['request']->getParameter('controllerName') . '.js')): ?>
        <script src="<?= $view['assets']->getUrl('js/' . $view['request']->getParameter('controllerName') . '.js') ?><?= (null !== $view['config']->get('js_version')) ? '?' . $view['config']->get('js_version') : '' ?>" type="text/javascript"></script>
    <?endif;?>

    <!--[if lt IE 7.]>
        <script defer src="<?= $view['assets']->getUrl('js/vendor/pngfix.js') ?>" type="text/javascript"></script>
    <![endif]-->

    <!--[if lt IE 10]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="<?= $view['assets']->getUrl('js/vendor/jquery.placeholder.js') ?>"></script>
    <![endif]-->
</head>

<body data-controller="<?= $view['request']->getParameter('controllerName'); ?>" data-action="<?= $view['request']->getParameter('actionName') ?>" itemscope itemtype="http://schema.org/WebPage">

    <section class="traffic-boundaries">
        <?= $view['actions']->render('RaetingLocalizationBundle:Localization:languages', array('request' => $view['request']->getRequest())) ?>
        <? $view['slots']->output('_content') ?>
    </section>
    
    <footer class="traffic-boundaries">
        <div class="traffic">
            <div class="moving_bus"></div>
            <div class="moving_bike"></div>
            <div class="moving_bike2"></div>
            <div class="moving_truck"></div>
            <div class="moving_truck2"></div>
        </div>

        <div class="wrapper">
            <div class="news_social">
                <div class="newsletter_signup">
                    <?= $view['actions']->render('RaetingCoreBundle:Newsletter:index', array('request' => $view['request']->getRequest())) ?>
                </div>
                <ul class="social">
                    <li><a href="http://www.weibo.com/raeting" title="<?=$view['translation']->trans('front.social.weibo')?>"><img src="<?=$view['assets']->getUrl('images/icon_social_weibo.png');?>" alt="<?=$view['translation']->trans('front.social.weibo')?>" /></a></li>
                    <li><a href="http://www.renren.com/raeting" title="<?=$view['translation']->trans('front.social.renren')?>"><img src="<?=$view['assets']->getUrl('images/icon_social_renren.png');?>" alt="<?=$view['translation']->trans('front.social.renren')?>" /></a></li>
                    <li><a href="https://www.facebook.com/Raeting" title="<?=$view['translation']->trans('front.social.facebook')?>"><img src="<?=$view['assets']->getUrl('images/icon_social_facebook.png');?>" alt="<?=$view['translation']->trans('front.social.facebook')?>" /></a></li>
                    <li><a href="https://twitter.com/raeting" title="<?=$view['translation']->trans('front.social.twitter')?>"><img src="<?=$view['assets']->getUrl('images/icon_social_twitter.png');?>" alt="<?=$view['translation']->trans('front.social.twitter')?>" /></a></li>
                    <li><a href="http://www.youtube.com/RaetingTravel" title="<?=$view['translation']->trans('front.social.youtube')?>"><img src="<?=$view['assets']->getUrl('images/icon_social_youtube.png');?>" alt="<?=$view['translation']->trans('front.social.youtube')?>" /></a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div>
                <?=$view['actions']->render('RaetingPageBundle:Page:getPage', array('id' => $view['page']->getPageIdBySlug('footer')));?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="bottombar">
            <div class="wrapper">
                <div class="tagline">
                    <img class="copyright_logo" src="<?=$view['assets']->getUrl('images/logo_xsmall.png');?>" alt="" />
                    <p class="copyright">
                        <?=$view['translation']->trans('core.footer.raeting_connects')?>
                    </p>
                    <p class="copyright">&copy; <?=$view['translation']->trans('core.footer.copyright')?> <?=date('Y')?></p>
                </div>
                <ul class="footer_menu">
                    <?=$view['actions']->render('RaetingPageBundle:Page:getPage', array('id' => $view['page']->getPageIdBySlug('footer-links')));?>
                    <li class="merchant_li">
                        <a href="<? if ($view['security']->isGranted('IS_AUTHENTICATED_FULLY')) :
                                echo $view['router']->generate('merchant.home');
                            else :
                                echo $view['router']->generate('merchant.welcome');
                            endif;
                            ?>" class="merchant_login">
                            <?=$view['translation']->trans('core.footer.merchant')?>
                            <span></span></a>
                    </li>
                </ul>
            <div class="clear"></div>
            </div>
        </div>
    </footer>
    <? if ($view['request']->getParameter('language') == 'zh' && null != $view['config']->get('baidu.tracker')):?>
        <script type="text/javascript">
            var _tracker = '<?=$view['config']->get('baidu.tracker');?>';
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F" + _tracker + "' type='text/javascript'%3E%3C/script%3E"));
        </script>
    <? endif; ?>

    <? if (null != $view['config']->get('google.tracker')):?>
        <script type="text/javascript">

             var _gaq = _gaq || [];
             _gaq.push(['_setAccount', '<?=$view['config']->get('google.tracker');?>']);
             _gaq.push(['_trackPageview']);

             (function() {
               var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
               ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
               var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
             })();

           </script>

    <? endif; ?>
</body>

</html>
