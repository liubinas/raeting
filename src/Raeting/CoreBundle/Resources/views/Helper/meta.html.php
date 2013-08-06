<? if($canonical):?>
<link rel="canonical" href="<?= $view['request']->getRootUrl(); ?>" />
<? endif;?>
<? if (!empty($title)): ?>
    <title><?=$title?></title>
<? else: ?>
    <title>Raeting</title>
<? endif; ?>
<meta name="keywords" content="<?=$keywords?>">
<meta name="description" content="<?=$description?>">