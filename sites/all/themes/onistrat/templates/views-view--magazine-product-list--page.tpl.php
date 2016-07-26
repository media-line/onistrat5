<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
?>

<?php
/**
 * составление дерева терминов 
 */
function taxonomyTree($terms, $parent = 0) {
  $items = array();
 
  foreach ($terms as $term) {
    if (in_array($parent, $term->parents)) {
      $items[] = array(
        //'name' => $term->name,
        'link' => l($term->name,  'taxonomy/term/' . ($term->tid)),
        'children' => taxonomyTree($terms, $term->tid),
      );
    }
  }
 
  return $items;
}
?>
<div class="<?php print $classes; ?>">

    <div class="uk-header-image">
        <?php
            // выводим блок большой картинки для шапки
            $block = block_load('block', '7');
            $block_content = _block_get_renderable_array(_block_render_blocks(array($block)));
            print render($block_content);
        ?>
        <div class="uk-header-image-caption uk-text-uppercase">
            <?php print render($title_prefix); ?>
            <?php if ($title): ?>
                <?php print $title; ?>
            <?php endif; ?>
            <?php print render($title_suffix); ?>
            <?php if ($header): ?>
                <div class="view-header">
                    <?php print $header; ?>
                </div>
            <?php endif; ?>
            <a href="#" onclick="history.back()">Вернуться назад</a>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <ul class="uk-term-list">
                <?php
                    // Вывод списка терминов из словаря
                    // работает только для 2-ух уровней вложенности
                    // id словаря который нужно получить
                    $vocabularieId = 3;
                    $terms = taxonomy_get_tree($vocabularieId);
                    //dsm($terms);
                    $termsTree = taxonomyTree($terms);
                    foreach($termsTree as $term){
                ?>
                        <li><?php echo $term['link'];?>
                        
                            <?php if(count($term['children']) > 0){ ?>
                                <ul class="uk-term-list-child">
                                <?php foreach($term['children'] as $childTerm){?>
                                
                                    <li><?php echo $childTerm['link'];?></li>
                                    
                                <?php } ?>
                                </ul>
                            <?php } ?>
                        
                        </li>
                <?php } ?>
                
                </ul>
            </div>

            <div class="col-lg-9 col-md-9 col-sm-9">
                <?php if ($exposed): ?>
                    <div class="view-filters">
                        <?php print $exposed; ?>
                    </div>
                <?php endif; ?>

                <?php if ($attachment_before): ?>
                    <div class="attachment attachment-before">
                        <?php print $attachment_before; ?>
                    </div>
                <?php endif; ?>

                <?php if ($rows): ?>
                    <div class="view-content">
                        <?php print $rows; ?>
                    </div>
                <?php elseif ($empty): ?>
                    <div class="view-empty">
                        <?php print $empty; ?>
                    </div>
                <?php endif; ?>

                <?php if ($pager): ?>
                    <?php print $pager; ?>
                <?php endif; ?>

                <?php if ($attachment_after): ?>
                    <div class="attachment attachment-after">
                        <?php print $attachment_after; ?>
                    </div>
                <?php endif; ?>

                <?php if ($more): ?>
                    <?php print $more; ?>
                <?php endif; ?>

                <?php if ($footer): ?>
                    <div class="view-footer">
                        <?php print $footer; ?>
                    </div>
                <?php endif; ?>

                <?php if ($feed_icon): ?>
                    <div class="feed-icon">
                        <?php print $feed_icon; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /* class view */ ?>
