<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 * - $view: The view object
 * - $rows: The raw result object from the query, with all data it fetched.
 */
?>

<div class="uk-video-section container">
    <div class="row">
    <?php 
        foreach($view->result as $result){
            //получаем ноду, ее алиас и дату
            $node = node_load($result->nid);
            //$alias = drupal_get_path_alias('node/'.$result->nid);
            //$date = $node->created;
            
            //получаем поля ноды
            $fieldVideo = field_get_items('node', $node, 'field_video'); 
            $videoUrl = field_view_value('node', $node, 'field_video', $fieldVideo[0]); 
            
            //обрабатываем ссылку на видео
            $urlParts = parse_url(render($videoUrl));
            $host = $urlParts['host'];
            
            if($host == 'www.youtube.com'){
                if(preg_match('/v=([^&]*)/',$urlParts['query'],$matches)) 
                    $videoId = $matches[1]; 
            } else if($host == 'youtu.be'){
                $videoId = str_replace('/', '', $urlParts['path']);
            } else if($urlParts['path'] != ''){
                $videoId = $urlParts['path'];
            } else $videoId = '';
    ?> 

            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="uk-video-item wow fadeIn">        
                    <?php if($videoId != ''){ ?>
                        <iframe width="100%" height="345" src="https://www.youtube.com/embed/<?php echo $videoId; ?>" frameborder="0" allowfullscreen></iframe>
                    <?php } ?>
                </div>
            </div>
    <?php } ?>
    </div>
</div>          
