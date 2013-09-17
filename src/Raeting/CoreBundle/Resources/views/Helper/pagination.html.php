<div class="row">
        <div class="table-footer">
                <div class="col-md-12">
                        <ul class="pagination">
                                <?php if ($page != 1):?>
                                <li><a href="<?= $view['router']->generate($route, array_merge(array('page' => 1), $params)); ?>">First(1)</a></li>
                                <?php endif;?>
                                <?php if ($urlPrev):?>
                                <li><a href="<?= $view['router']->generate($route, array_merge(array('page' => $page-1), $params)); ?>">&larr; Prev</a></li>
                                <?php endif;?>
                                <? foreach($pages as $pageNumber): ?>
                                <li<?= $page==$pageNumber?' class="active"':'' ?>><a href="<?= $view['router']->generate($route, array_merge(array('page' => $pageNumber), $params)); ?>"><?= $pageNumber; ?></a></li>
                                <? endforeach; ?>
                                <?php if ($urlNext):?>
                                <li><a href="<?= $view['router']->generate($route, array_merge(array('page' => $page+1), $params)); ?>">Next &rarr;</a></li>
                                <?php endif;?>
                                <?php if ($page != $total && $totalPages > 1):?>
                                <li><a href="<?= $view['router']->generate($route, array_merge(array('page' => $totalPages), $params)); ?>">Last(<?= $totalPages ?>)</a></li>
                                <?php endif;?>
                        </ul>
                </div>
        </div>
</div>