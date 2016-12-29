<?php defined('SYSPATH') or die('No direct script access.');?>


<div class="bgban"></div>
    <div class="row">
        <?$i=0; foreach($categs as $c):?>
            <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                <div class="col-md-4 col-sm-6">
                    <div class="panel panel-home-categories">
                        <div class="panel-heading">
                            <a title="<?=HTML::chars($c['name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=mb_strtoupper($c['name']);?></a>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <?foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <li class="list-group-item">
                                            <a title="<?=HTML::chars($chi['name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['name'];?>
                                                <?if (Theme::get('category_badge')!=1) : ?>
                                                    <span class="pull-right badge badge-success"><?=number_format($chi['count'])?></span>
                                                <?endif?>
                                            </a>
                                        </li>
                                    <?endif?>
                                 <?endforeach?>
                            </ul>
                        </div>
                    </div>
                </div>
                <? $i++; if ($i%3 == 0) echo '<div class="clear hidden-sm"></div>';?>
            <?endif?>
        <?endforeach?>
    </div>

<?if(core::config('advertisement.ads_in_home') != 3):?>

        <h3>
            <?if(core::config('advertisement.ads_in_home') == 0):?>
                <?=_e('Latest Ads')?>
            <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
                <?=_e('Featured Ads')?>
            <?elseif(core::config('advertisement.ads_in_home') == 2):?>
                <?=_e('Popular Ads last month')?>
            <?endif?>
            <?if ($user_location) :?>
                <small><?=$user_location->name?></small>
            <?endif?>
        </h3>

    <?$i=0; foreach($ads as $ad):?>
        <article class="panel ltest clearfix">
            <div class="panel-body">
                <div class="picture">
                  <a class="pull-left" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                      <figure>
                          <?if($ad->get_first_image() !== NULL):?>
                              <img src="<?=Core::imagefly($ad->get_first_image(),100,100)?>" alt="<?=HTML::chars($ad->title)?>" />
                          <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                              <img src="<?=Core::imagefly($icon_src,150,150)?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>" />
                          <?elseif(( $icon_src = $ad->location->get_icon() )!==FALSE ):?>
                              <img src="<?=Core::imagefly($icon_src,150,150)?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>" />
                          <?else:?>
                              <img data-src="holder.js/100x100?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->name, 'size' => 14, 'auto' => 'yes')))?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>">
                          <?endif?>
                      </figure>
                  </a>
                </div>
                <h3>
                  <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                      <?=$ad->title?>
                  </a>
                </h3>
                <ul>
                  <?if (core::request('sort') == 'distance' AND Model_User::get_userlatlng()) :?>
                      <li><strong><?=_e('Distance');?>:</strong> <?=i18n::format_measurement($ad->distance)?></li>
                  <?endif?>
                  <?if ($ad->price!=0){?>
                      <li class="price text-success"><strong><span class="price-curry"><?=i18n::money_format( $ad->price)?></span></strong></li>
                  <?}?>
                  <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                      <li class="price"><?=_e('Price');?>: <strong><?=_e('Free');?></strong></li>
                  <?}?>
                </ul>
                <p>
                <?if(core::config('advertisement.description')!=FALSE):?>
                    <?=Text::limit_chars(Text::removebbcode($ad->description), 255, NULL, TRUE);?>
                <?endif?>
                    <a title="<?=HTML::chars($ad->seotitle);?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="glyphicon glyphicon-share"></i> <?=_e('Read more')?></a>
                </p>
            </div>
        </article>
    <?endforeach?>

<?endif?>

<?if(core::config('general.auto_locate') AND ! Cookie::get('user_location') AND Core::is_HTTPS()):?>
    <input type="hidden" name="auto_locate" value="<?=core::config('general.auto_locate')?>">
    <?if(count($auto_locats) > 0):?>
        <div class="modal fade" id="auto-locations" tabindex="-1" role="dialog" aria-labelledby="autoLocations" aria-hidden="true">
            <div class="modal-dialog	modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="autoLocations" class="modal-title text-center"><?=_e('Please choose your closest location')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <?foreach($auto_locats as $loc):?>
                                <a href="<?=Route::url('default')?>" class="list-group-item" data-id="<?=$loc->id_location?>"><span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span> <?=$loc->name?> (<?=i18n::format_measurement($loc->distance)?>)</a>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
<?endif?>
