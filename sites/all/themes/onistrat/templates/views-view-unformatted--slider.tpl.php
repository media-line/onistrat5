<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div class="uk-slider">
	<div id="main-slider" class="carousel slide" data-ride="carousel" data-interval="false" data-pause="false">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>

		<!-- Wrapper for slides -->
        <div class="carousel-inner">
            
            <?php foreach ($rows as $k => $row){
                if ($k == 0){
                    $class= ' active';
                } else $class= '';
            ?>
                <div class="item<?php echo($class); ?>"> 
                    <?php echo($row); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
