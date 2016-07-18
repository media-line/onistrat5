<?php
/**
 * @file
 * Template to display a column
 * 
 * - $item: The item to render within a td element.
 */
?>
<?php 
	$date = (isset($item['date'])) ? ' data-date="' . $item['date'] . '" ' : '';
	$dayOfMonth = (isset($item['day_of_month'])) ? $item['day_of_month'] : '';
	$day = (isset($item['day_of_month'])) ? ' data-day-of-month="' . $item['day_of_month'] . '" ' : '';
	$headers = (isset($item['header_id'])) ? ' headers="'. $item['header_id'] .'" ' : '';
	
	//Получение текущего URL и параметров
	global $base_url; 
	$currentUrl = $base_url.base_path().request_path();
	$queryParams = drupal_get_query_parameters();
	//URL-ы для возврата с платежной системы (если нет параметров)
	$currentUrlSuccess = $currentUrl.'/?pay_status=success';
	$currentUrlFailed = $currentUrl.'/?pay_status=failed';
	
	//Получение текущего месяца календаря
	$currentDate = explode(',', date('d,m,Y'));
	if(isset($queryParams['mini'])){
		$calendarDate = explode('-', $queryParams['mini']);
		$calendarMonth = $calendarDate[1];
		//URL-ы для возврата с платежной системы (если есть параметры)
		$currentUrlSuccess = $currentUrl.'/?mini='.$queryParams['mini'].'&pay_status=success';
		$currentUrlFailed = $currentUrl.'/?mini='.$queryParams['mini'].'&pay_status=failed';
	} else {
		$calendarMonth = $currentDate[1];
	}

	//Получение месяца для выводимого дня
	$monthOfTheDay = date('m', strtotime($item['date']));

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
        
			<?php if($monthOfTheDay == $calendarMonth){ ?>
				<div class="uk-calendar-coll-header ">
					<div class="uk-calendar-day">
						<?php print $dayOfMonth; ?>
					</div>
				</div>
					
				<div class="uk-event">
					<?php print $item['entry']; ?>
				</div>
			<?php } ?>
        </div>
                
    <?php } ?>
<?php } else { ?>
    <div <?php print $id?>class="uk-calendar-coll uk-event-exsist"<?php print $date . $headers . $day; ?> data-toggle="modal" data-target="#event-modal-<?php echo $item['item']->id;?>">
        <div class="uk-event-yellow-overlay"></div>
        <?php if($monthOfTheDay == $calendarMonth){ ?>
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
				
			<? } ?>
		<?php } ?>
    </div>
	<div class="modal fade" id="event-modal-<?php echo $item['item']->id;?>" tabindex="-1" role="dialog" aria-labelledby="event-modal-label" aria-hidden="true">
		<?php 
			//Окончательное формирование URL-ов для возврата с платежной системы
			$currentUrlSuccess .= '&modal=' . $item['item']->id;
			$currentUrlFailed  .= '&modal=' . $item['item']->id;
		
		?>
		<div class="modal-dialog">
			<div class="modal-content uk-events-modal-content container-fluid">
				<a type="button" class="close uk-close uk-events-modal-close uk-bordered-remove" data-dismiss="modal" aria-hidden="true">&times;</a>
				
				<div class="row">
					<div class="col-md-5">
						<div class="uk-ev-mod-content-image">
							<?php echo $item['item']->rendered_fields['field_image']; ?>
							<a href="#" class="uk-ev-mod-content-button uk-bordered-remove"><?php echo t('Записаться на семинар');?></a>
						</div>
					</div>
					<div class="col-md-7">
						<div class="uk-ev-mod-content-title">
							<?php echo $item['item']->title;?>
						</div>
						
						<div class="uk-ev-mod-content-text">
							<?php echo $item['item']->rendered_fields['body'];?>
						</div>
						<div class="uk-ev-mod-content-price">
							<?php echo $item['item']->rendered_fields['field_price'];?>
						</div>
					</div>
				</div>
				<form class="uk-event-form" action="https://www.portmone.com.ua/gateway/" method="post"> 
					
					<input type="text" name="name" placeholder="Имя"/>
					<input type="text" name="name" placeholder="Фамилия"/>
					<input type="text" name="name" placeholder="Email"/>
					
					<input type="hidden" name="check"/>
					
						<input type="hidden" name="payee_id" value="10862" />
						<input type="hidden" name="shop_order_number" value="100" />
						<input type="hidden" name="bill_amount" value="<?php echo $item['item']->rendered_fields['field_price'];?>"/>
						<input type="hidden" name="description" value="<?php echo $item['item']->title;?>"/>
						<input type="hidden" name="success_url" value="<?php echo $currentUrlSuccess;?>" />
						<input type="hidden" name="failure_url" value="<?php echo $currentUrlFailed;?>" />
						<input type="hidden" name="encoding" value="utf-8"/>
						<input type="hidden" name="lang" value="ru" />
						
					<button type="submit" class="uk-ev-mod-content-button">Оплатить</button>
				</form>
			</div>
		</div>
	</div>
	<?php 
		//Открытие модального окна после возврата с платежки
		if(isset($queryParams['modal'])){
			echo '<script>';
			echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").modal("show")';
			echo '</script>';
		}
	?>
<?php } ?>
