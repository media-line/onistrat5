<?php
/**
 * @file
 * Template to display a row
 * 
 * - $inner: The rendered string of the row's contents.
 */
?>


<?php if (trim($inner) != ''){ ?>
    <div class="uk-calendar-row">
        <?php print $inner; ?>
    </div>
<?php } ?>