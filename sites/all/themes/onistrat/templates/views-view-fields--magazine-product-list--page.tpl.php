<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<?php 
    //Получение полей
    foreach($fields as $id => $field){
        switch($id) {
            case 'title':
                $title = $field->content;
                break;

            case 'field_image':
                $fieldImage = $field->content;
                break;

            case 'commerce_price':
                $commercePrice = $field->content;
                break;

            case 'view_node':
                $fieldLink = $field->content;
                break;

        }

    }

    //Получение src изображения
    preg_match('/<img[^>]+>/i', $fieldImage, $img);
    preg_match("/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/", $img[0], $matches);
    $imageUrl = $matches[1];
    
    //Получение href ссылки
    preg_match('/<a[^>]+>/i', $fieldLink, $link);
    preg_match("/\<a.+href\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)/", $link[0], $matches);
    $linkUrl = $matches[1];
?>

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a href="<?php echo $linkUrl; ?>" class="uk-catalog-teaser uk-bordered-remove uk-text-uppercase uk-text-light uk-h3">
            <span class="uk-catalog-teaser-image">
                <span class="uk-block-alignment"></span>
                <span class="uk-img-block" style="background-image: url(<?php echo $imageUrl; ?>);"></span>
            </span>
            <span class="uk-catalog-teaser-title">
                <?php echo $title; ?>
            </span>
            <span class="uk-catalog-teaser-price">
                <?php echo $commercePrice; ?>
            </span>
        </a>
    </div>
