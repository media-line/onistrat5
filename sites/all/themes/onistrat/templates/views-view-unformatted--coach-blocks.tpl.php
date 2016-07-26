<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 * - $view: The view object
 * - $rows: The raw result object from the query, with all data it fetched.
 
 */
?>

<div class="uk-coach-blocks">
    <div class="container">
        <div class="row">
        <?php 
            foreach($rows as $row){
                echo $row;
            } 
        ?>
        </div>
    </div>
</div>