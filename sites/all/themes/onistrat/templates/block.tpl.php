<?php
/**
 * @file
 * Returns the HTML for a block.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728246
 */
?>
<div class="<?php print $classes; ?> <?php print $block_html_id; ?>"<?php print $attributes; ?> id="<?php print $block_html_id; ?>">

  <?php if ($block->subject){ ?>
    <div class="block-title"><?php print $block->subject; ?></div>
  <?php } ?>
  <?php print $content; ?>

</div>
