<?php
/**
 * @file
 * Template to display a column
 * 
 * - $item: The item to render within a td element.
 */
$date = (isset($item['date'])) ? ' data-date="' . $item['date'] . '" ' : '';
$dayOfMonth = (isset($item['day_of_month'])) ? $item['day_of_month'] : '';
$day = (isset($item['day_of_month'])) ? ' data-day-of-month="' . $item['day_of_month'] . '" ' : '';
$headers = (isset($item['header_id'])) ? ' headers="'. $item['header_id'] .'" ' : '';
?>
<?php 
    if(isset($item['id'])) {
        $id = 'id="' . $item['id'] . '"';
        
        //Находим последнюю часть id, чтобы узнать, что это за item
        $itemId = explode('-', $item['id']);
        $lastNumber = count($itemId)-1;
        
    } else {
        $itemId = '';
        $lastNumber = 0;
        $id = '';
    }  
    
    //если на день назначены мероприятия
    if(isset($item['item'])) {
        $dayOfMonth = date('d', strtotime($item['date']));
    }
?>
<?php if(isset($item['id'])){ ?>
    
    <?php if(($itemId[$lastNumber] != 'box') && ($itemId[4] == 0)){ ?>
        <div <?php print $id?>class="uk-calendar-coll"<?php print $date . $headers . $day; ?>>
        
            <div class="uk-event-yellow-overlay"></div>
        
            <div class="uk-calendar-coll-header ">
                <div class="uk-calendar-day">
                    <?php print $dayOfMonth; ?>
                </div>
            </div>
                
            <div class="uk-event">
                <?php print $item['entry']; ?>
            </div>
        </div>
                
    <?php } ?>
<?php } else { ?>
    <div <?php print $id?>class="uk-calendar-coll uk-event-exsist"<?php print $date . $headers . $day; ?>>
        <div class="uk-event-yellow-overlay"></div>
        
        <div class="uk-calendar-coll-header clearfix">
            <?php if (intval($item['item']->rendered_fields['field_paid'])){?>
                <div class="uk-paid-event"><?php echo '$';?></div>
            <?php } ?>
            <div class="uk-calendar-day">
                <?php print $dayOfMonth; ?>
            </div>
        </div>
        
        <?php if(isset($item['item'])) {
                
            //получаем src картинки
            $doc = new DOMDocument();
            $doc->loadHTML($item['item']->rendered_fields['field_image']);
            $xpath = new DOMXPath($doc);
            $imageSrc = $xpath->evaluate("string(//img/@src)");
                
        ?>
                    
        <div class="uk-event-image" style="background-image: url(<?php echo $imageSrc; ?>);"> </div>  
            
        <div class="uk-event-title">
            <?php echo $item['item']->title;?>  
        </div>      
            
        <div class="hidden">
            <?php echo $item['item']->rendered_fields['body'];?>
        </div>
                        
        <? } else { ?>
            <?php print $item['entry']; ?>
        <?php } ?>
    </div>
<?php } ?>