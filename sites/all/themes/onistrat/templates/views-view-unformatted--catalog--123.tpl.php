<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 * - $view: The view object
 * - $rows: The raw result object from the query, with all data it fetched.
 */
?>

<div class="uk-text-center">
            <!-- Nav tabs -->
            <ul class="uk-tabs nav nav-tabs uk-inline-block" role="tablist">
                <li role="presentation" class="active">
                    <a class="uk-tab-switcher" href="#uk-tab-ferm" aria-controls="uk-tab-ferm" role="tab" data-toggle="tab">
                        Ферма
                    </a>
                </li>
                <li role="presentation">
                    <a class="uk-tab-switcher" href="#uk-tab-magazine" aria-controls="uk-tab-magazine" role="tab" data-toggle="tab">
                        Магазин
                    </a>
                </li>
            </ul>
</div>
<!-- Tab panes -->
<div class="tab-content uk-tab-content">
    <div role="tabpanel" class="tab-pane fade in active uk-catalog-tab container" id="uk-tab-ferm">
        <div class="row uk-catalog-row">
    <?php 

        foreach($view->result as $result){
            //получаем ноду, ее алиас и дату
            //$product = commerce_product_load($result->product_id);
            //$alias = drupal_get_path_alias('commerce/product/'.$result->product_id);
            //$product = entity_metadata_wrapper('commerce_product', $result->product_id);
            //dsm($wrapper->field_images->value());
            //$date = $product->created;
            //commerce_product
            //получаем поля ноды
            //$fieldImage = field_get_items('commerce_product', $product, 'field_images'); 
            
            $wrapper = entity_metadata_wrapper('commerce_product', $result->product_id);
            //$nodes   = $wrapper->field_product_node->value();
           // $path    = drupal_get_path_alias("node/".$result->product_id);
            dsm($path);
            
            /*$fieldImageOutput = field_view_value('commerce_product', $wrapper, 'field_images', $fieldImage[0]); 
            $fieldImageOutput = render($fieldImageOutput);
            
            $productTitleOutput = render($product->title);*/
            /*
            $nodeBody = field_get_items('node', $product, 'body'); 
            $nodeBodyOutput = field_view_value('node', $product, 'body',$nodeBody[0],'teaser'); 
            $nodeBodyOutput = render($nodeBodyOutput);*//*
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
    <?php*/ } ?>
        </div> 
    </div>
</div>