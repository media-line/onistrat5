<?php
/**
 * @video_file
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 * 
 */
?>
     
<?php 
    $file = ($row->field_field_video_file[0]['raw']);
    $fileUrl = file_create_url($file['uri']);
?>

<div class="uk-video-block">
    <video id="video-<?php echo $file['fid']; ?>" class="video"><source src="<?php echo $fileUrl; ?>" type="video/mp4"></video>
</div>
<a href="#" class="js-play uk-slide-layout-play uk-bordered-remove" data-video-id="video-<?php echo $file['fid']; ?>"></a>
<a href="#" class="js-pause uk-slide-layout-pause uk-bordered-remove" data-video-id="video-<?php echo $file['fid']; ?>"></a>