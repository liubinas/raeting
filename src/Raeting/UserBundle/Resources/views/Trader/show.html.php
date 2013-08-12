<? $view->extend('::base.html.php'); ?>

<? $view['slots']->start('header_row') ?>
    <div class="span5">
        <h2><?=$view['translator']->trans('User')?></h2>
    </div>
    <nav class="span4">
                    <a href="<?= $view['router']->generate('user') ?>" class="btn">
        <i class="icon-chevron-left"></i> 
        <?=$view['translator']->trans('Back to the list')?>
    </a>
    <a href="<?= $view['router']->generate('user_edit', array('id' => $entity->getId())) ?>" class="btn">
        <i class="icon-pencil"></i> 
        <?=$view['translator']->trans('Edit')?>
    </a>
    <a href="<?= $view['router']->generate('user_delete', array('id' => $entity->getId())) ?>" class="btn" onclick="return confirm('<?=$view['translator']->trans('Confirm delete')?>">
        <i class="icon-trash"></i>
        <?=$view['translator']->trans('Delete')?>
    </a>
    </nav>
<? $view['slots']->stop('header_row') ?>

<? $view['slots']->start('body') ?>
    <div class="box">
        <div class="row-fluid">
            <div class="content">
                <table>
                    <tbody>
                        <tr>
                            <th>Id</th>
                            <td><?=$entity->getid()?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?=$entity->getemail()?></td>
                        </tr>
                        <tr>
                            <th>Usergroup</th>
                            <td><?=$entity->getusergroup()?></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><?=$entity->getpassword()?></td>
                        </tr>
                        <tr>
                            <th>Firstname</th>
                            <td><?=$entity->getfirstname()?></td>
                        </tr>
                        <tr>
                            <th>Lastname</th>
                            <td><?=$entity->getlastname()?></td>
                        </tr>
                        <tr>
                            <th>Street</th>
                            <td><?=$entity->getstreet()?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?=$entity->getstate()?></td>
                        </tr>
                        <tr>
                            <th>Postalcode</th>
                            <td><?=$entity->getpostalCode()?></td>
                        </tr>
                        <tr>
                            <th>Createdon</th>
                            <td><?=($entity->getcreatedOn())?(string)$entity->getcreatedOn()->format("Y-m-d H:i:s"):"";?></td>
                        </tr>
                        <tr>
                            <th>Recoveryhash</th>
                            <td><?=$entity->getrecoveryHash()?></td>
                        </tr>
                        <tr>
                            <th>Recoverydate</th>
                            <td><?=($entity->getrecoveryDate())?(string)$entity->getrecoveryDate()->format("Y-m-d H:i:s"):"";?></td>
                        </tr>
                        <tr>
                            <th>Lastlogin</th>
                            <td><?=($entity->getlastLogin())?(string)$entity->getlastLogin()->format("Y-m-d H:i:s"):"";?></td>
                        </tr>
                        <tr>
                            <th>Facebook</th>
                            <td><?=$entity->getfacebook()?></td>
                        </tr>
                        <tr>
                            <th>Linkedin</th>
                            <td><?=$entity->getlinkedin()?></td>
                        </tr>                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? $view['slots']->stop('body') ?>