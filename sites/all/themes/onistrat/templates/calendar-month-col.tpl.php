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
	$currentDate = explode(',', date('m,Y'));
	if(isset($queryParams['mini'])){
		$calendarDate = explode('-', $queryParams['mini']);
		$calendarMonth = $calendarDate[0];
        $calendarYear = $calendarDate[1];
        
		//URL-ы для возврата с платежной системы (если есть параметры)
		$currentUrlSuccess = $currentUrl.'/?mini='.$queryParams['mini'].'&pay_status=success';
		$currentUrlFailed = $currentUrl.'/?mini='.$queryParams['mini'].'&pay_status=failed';
	} else {
		$calendarMonth = $currentDate[0];
        $calendarYear = $currentDate[1];
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
				<?php 
                    if (intval($item['item']->rendered_fields['field_paid'])){
                        $formAction = 'https://www.portmone.com.ua/gateway/';
                ?>
                        <div class="uk-paid-event"><?php echo '$';?></div>
                    
				<?php } else {
                    
                    $formAction = '';
                    
                }?>
                
				<div class="uk-calendar-day">
					<?php print $dayOfMonth; ?>
				</div>
			</div>
			
			<?php if(isset($item['item'])) {
					
				//получаем src картинки
				$doc = new DOMDocument();
				$doc->loadHTML($image);
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
			<div class="modal-content uk-black-modal-content container-fluid">
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
                
				<form id="event-form-<?php echo $item['item']->id;?>" class="uk-event-form row" action="<?php echo $formAction; ?>" method="post"> 
					
                    <div class="col-md-4">
                        <input class="uk-name uk-form-control" type="text" name="name" placeholder="Имя" required/>
                    </div>
                    
                    <div class="col-md-4">
                        <input class="uk-lastname uk-form-control" type="text" name="last_name" placeholder="Фамилия" required/>
                    </div>
                    
                    <div class="col-md-4">
                        <input class="uk-email uk-form-control" type="email" name="email" placeholder="Email" required/>
                    </div>
					
					<input class="uk-subject"  type="hidden" name="subject" value="<?php echo $item['item']->title; ?>"/>
					<input class="uk-date" type="hidden" name="date" value="<?php echo $dayOfMonth . '.' . $calendarMonth . '.' . $calendarYear; ?> "/>
					<input type="hidden" name="check"/>
                        
                    <?php
                        //Если мероприятие платное
                        if (intval($item['item']->rendered_fields['field_paid'])){
                            
                        //Формирование номера заказы из даты
                        $orderNumber = date('YmdhGis');
                    ?>
						<input type="hidden" name="form_action" value="<?php echo $formAction; ?>" />
						<input type="hidden" name="payee_id" value="10862" />
						<input type="hidden" name="shop_order_number" value="<?php echo $orderNumber;?>" />
						<input type="hidden" name="bill_amount" value="<?php echo $item['item']->rendered_fields['field_price'];?>"/>
						<input type="hidden" name="description" value="<?php echo $item['item']->title;?>"/>
						<input class="uk-success-url" type="hidden" name="success_url" value="<?php echo $currentUrlSuccess;?>" />
						<input class="uk-failed-url" type="hidden" name="failure_url" value="<?php echo $currentUrlFailed;?>" />
						<input type="hidden" name="encoding" value="utf-8"/>
						<input type="hidden" name="lang" value="ru" />
                        <div class="uk-text-center">	
                            <button class="uk-ev-mod-pay-button uk-paid">Оплатить</button>
                            <span class="uk-success-pay-message">
                                Оплата произведена успешно!
                            </span>
                            <span class="uk-failed-pay-message">
                                Ошибка, оплата не была произведена.
                            </span>
                        </div>
                    <?php } else { ?>
                        <div class="uk-text-center">	
                            <button type="submit" class="uk-ev-mod-pay-button uk-free">Записаться</button>
                        </div>
                    <?php } ?>
				</form>
			</div>
		</div>
	</div>

	<?php 
        
		//Открытие модального окна после возврата с платежки
		if(isset($queryParams['modal'])){
			echo '<script>';
			echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").modal("show");';
            //Открытие формы заказа
            echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").find(".uk-ev-mod-content-button").addClass("uk-disable");';
            echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").find(".uk-event-form").slideDown(500);';
            //Сообщение об оплате
            echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").find(".uk-success-pay-message, .uk-failed-pay-message").hide();';
            echo 'jQuery("#event-modal-' . $queryParams['modal'] . '").find(".uk-' . $queryParams['pay_status'] .'-pay-message").fadeIn(300);';
			echo '</script>';
		}
	?>
<?php } ?>
