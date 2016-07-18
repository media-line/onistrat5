<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 * - $view: The view object
 * - $rows: The raw result object from the query, with all data it fetched.
 */
?>

<div class="uk-section-about">
<div id="about-slider" class="uk-section-about carousel uk-carousel-about slide" data-ride="carousel" data-interval="false" data-pause="false">
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
    <?php 
        foreach($view->result as $k=>$result){
            //получаем ноду, ее алиас и дату
            $node = node_load($result->nid);
            $alias = drupal_get_path_alias('node/'.$result->nid);
            $date = $node->created;
            
            //получаем поля ноды
            $fieldImage = field_get_items('node', $node, 'field_image'); 
            $fieldImageOutput = field_view_value('node', $node, 'field_image', $fieldImage[0]); 
            $fieldImageOutput = render($fieldImageOutput);
            
            $nodeTitleOutput = render($node->title);
            
            $fieldSubtitle = field_get_items('node', $node, 'field_subtitle'); 
            $fieldSubtitleOutput = field_view_value('node', $node, 'field_subtitle', $fieldSubtitle[0]); 
            $fieldSubtitleOutput = render($fieldSubtitleOutput);
            
            $nodeBody = field_get_items('node', $node, 'body'); 
            $nodeBodyOutput = field_view_value('node', $node, 'body',$nodeBody[0],'teaser'); 
            $nodeBodyOutput = render($nodeBodyOutput);
    ?> 

            <div class="item<?php if($k == 0) echo ' active';?> container-fluid">
                <div class="row">
                    <div class="uk-about-image js-about-image uk-sm-width-50 uk-md-width-45">
                        <div class="uk-text-right">
                            <?php echo $fieldImageOutput; ?>
                        </div>
                    </div>
                    
                    <div class="uk-about-content uk-sm-width-50 uk-md-width-55">
                        <div class="uk-about-title uk-text-bold uk-text-uppercase wow fadeInDown" data-wow-delay="0.3s">
                            <?php echo $nodeTitleOutput; ?>
                        </div>
                        <div class="uk-about-subtitle uk-h3 uk-text-light uk-text-uppercase wow fadeInUp" data-wow-delay="0.5s">
                            <?php echo $fieldSubtitleOutput; ?>
                        </div>
                        <div class="uk-about-content-main wow fadeInUp" data-wow-delay="0.5s">
                            <?php echo $nodeBodyOutput; ?>
                        </div>
                        <div>
                            <?php if($k > 0){ ?>
                                <a class="uk-button uk-button-wh wow fadeInUp" href="#about-slider" data-wow-delay="0.4s" role="button" data-slide="prev">
                                    Назад
                                </a>
                            <?php } ?>
                            <a class="uk-button uk-button-wh wow fadeInUp" data-wow-delay="0.6s" href="#about-slider" role="button" data-slide="next">
                                Далее
                            </a>
                        </div>
                    </div>
                </div>
			</div>
    <?php } ?>
    </div>
</div>
</div>