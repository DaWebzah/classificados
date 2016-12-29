<?php defined('SYSPATH') or die('No direct script access.');?>

<footer class="footer">
    <div class="container">
    <div class="row">
        <?$i=0; foreach ( Widgets::render('footer') as $widget):?>
            <div class="col-md-3">
                <?=$widget?>
            </div>
            <? $i++; if ($i%4 == 0) echo '<div class="clearfix"></div>';?>
        <?endforeach?>
    </div>
    <!--This is the license for Open Classifieds, do not remove -->
    <div class="center-block">
        <p>&copy;
                <?=core::config('general.site_name')?> <?=date('Y')?>
            <?if(Cookie::get('user_location')):?>
                - <a href="<?=Route::url('default')?>?user_location=0"><?=_e('Change Location')?></a>
            <?endif?>
        </p>
        <a href="https://classificados.florianopol.is/contact.html"><i class="glyphicon glyphicon-envelope"></i> Contact</a>

    </div>
    </div>
</footer>
