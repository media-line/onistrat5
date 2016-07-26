<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div class="uk-catalog-list">
    <?php if (!empty($title)): ?>
        <div><?php print $title; ?></div>
    <?php endif; ?>
    
    <div class="container-fluid">
        <div class="row uk-catalog-row">
            <?php 
                foreach($rows as $row){
                    echo $row;
                } 
            ?>
        </div>
    </div>
</div>

