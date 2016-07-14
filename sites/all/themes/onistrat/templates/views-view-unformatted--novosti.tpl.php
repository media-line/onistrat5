<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 * - $view: The view object
 * - $rows: The raw result object from the query, with all data it fetched.
 */
?>

<div class="col-sm-12 col-md-6">
    <div class="uk-blog-news">
    <?php 
        foreach($view->result as $result){
            //получаем ноду, ее алиас и дату
            $node = node_load($result->nid);
            $alias = drupal_get_path_alias('node/'.$result->nid);
            $date = $node->created;
            
            //получаем поля ноды
            $fieldImage = field_get_items('node', $node, 'field_image'); 
            $fieldImageOutput = field_view_value('node', $node, 'field_image', $fieldImage[0]); 
            $fieldImageOutput = render($fieldImageOutput);
            
            $nodeTitleOutput = render($node->title);
            
            $nodeBody = field_get_items('node', $node, 'body'); 
            $nodeBodyOutput = field_view_value('node', $node, 'body',$nodeBody[0],'teaser'); 
            $nodeBodyOutput = render($nodeBodyOutput);
    ?> 

            <div class="uk-blog-news-item container-fluid">
                <div class="row">        
                    <a class="uk-blog-news-item-img uk-width-30 uk-bordered-remove" href="<?php echo $alias; ?>">    
                        <?php echo $fieldImageOutput; ?>
                    </a>
                    <div class="uk-blog-news-content uk-width-70">
                        <div class="uk-blog-news-date uk-h3 uk-text-uppercase uk-text-light"><?php echo format_date($date, 'long'); ?></div>
                        <a class="uk-blog-news-title uk-h1 uk-text-uppercase uk-text-bold" href="<?php echo $alias; ?>">
                            <?php echo $nodeTitleOutput; ?>
                        </a>
                        <div class="uk-blog-news-text uk-h3 uk-margin-small-top">
                            <?php echo $nodeBodyOutput; ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php } ?>
    </div>
</div>