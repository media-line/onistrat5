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
        $fieldContent[$id] = $field->content;
    } 
    $numberOfStars = intval($fieldContent['field_stars']);
    
    //Данные для платежной системы
    //Формирование номера заказы из даты
    $orderNumber = date('YmdhGis');
    
    //Url платежного шлюза
    $formAction = 'https://www.portmone.com.ua/gateway/';
    
    //Текущий url
    global $base_url; 
	$currentUrl = $base_url.base_path().request_path();
    //Параметры url
    $queryParams = drupal_get_query_parameters();
    
    //Ссылки для возврата с платежки
    $currentUrlSuccess = $currentUrl 
                            . '?pay_status=success&modal=' 
                            . $fieldContent['nid'];
    $currentUrlFailed = $currentUrl 
                            . '?pay_status=failed&modal='
                            . $fieldContent['nid'];
                            
?>

<?php 

    //Отправка почты
    if(isset($queryParams['pay_status']) && ($queryParams['pay_status'] == 'success')){
        if(isset($_POST['SHOPORDERNUMBER'])){
            $siteEmail = variable_get('site_mail', '');
            $name = htmlspecialchars($queryParams['name']);
            $phone = htmlspecialchars($queryParams['phone']);
            $email = htmlspecialchars($queryParams['email']);
            $subject = htmlspecialchars($queryParams['subject']);
            $headers = 'From: admin <' . $siteEmail . ">\r\n";
            $headers .= "Content-type: text/html; charset=\"utf-8\"";
            
            $body = 'Страница - Персональный коучинг<br>';
            $body .= 'Услуга - ' . $subject . '<br>';
            $body .= 'Данные:<br>';
            $body .= '<strong> Фио: </strong>'. $name .'<br>';
            $body .= '<strong> Телефон: </strong>'. $phone .'<br>';
            $body .= '<strong> Email: </strong>'. $email .'<br>';
                
            $userBody = 'Здравствуйте.<br>';
            $userBody .= 'Вы записались на "'.$subject . '".<br>';
            $userBody .= 'С Вами скоро свяжется наш менеджер!';
                
            if(mail($siteEmail, 'Вы записались на "'. $subject.'"', $userBody, $headers)){}
            
            if(mail($siteEmail, 'Новая заявка на "'.$subject.'"', $body, $headers)){
                unset($_POST['SHOPORDERNUMBER']);
                
                //Удаление гет-параметров после возврата с платежки   
                //Ненужные параметры
                $removeParams = array('subject', 'name', 'phone', 'email'); 
                $redirectParams = '/?';
                foreach($queryParams as $k => $param){
                    if (!in_array($k, $removeParams)){
                        $redirectParams .= $k . '=' . $param . '&';
                    }
                }
                $redirectParams = substr($redirectParams, 0 , -1);
                // dsm($base_url.$requestUrl.$redirectParams);
                header('Location: '.$currentUrl.$redirectParams);
            }
        }
    }
    
?>

<?php 
	//Открытие модального окна после возврата с платежки
	if(isset($queryParams['modal'])){
?>
        <script>
            jQuery("#modal-block-<?php echo $queryParams['modal']; ?>").modal("show");
            //Открытие формы заказа
            jQuery("#modal-block-<?php echo $queryParams['modal']; ?>").find(".uk-ev-mod-content-button").addClass("uk-disable");
            jQuery("#modal-block-<?php echo $queryParams['modal']; ?>").find(".uk-event-form").slideDown(500);
            //Сообщение об оплате
            jQuery("#modal-block-<?php echo $queryParams['modal']; ?>").find(".uk-success-pay-message, .uk-failed-pay-message").hide();
            jQuery("#modal-block-<?php echo $queryParams['modal']; ?>").find(".uk-<?php echo $queryParams['pay_status']; ?>-pay-message").fadeIn(300);
        </script>
<?php } ?>


    <div class="uk-coach-block col-xs-12 col-md-4">
        <div class="uk-coach-block-stars">
            <?php if($numberOfStars > 0){ ?>
                <?php for($i = 0; $i < $numberOfStars; $i++){ ?>
                    <span class="uk-coach-block-stars-star icon-favorite"></span> 
                <?php } ?>
            <?php } ?>
        </div> 
        <div class="uk-coach-block-title">
            <?php echo $fieldContent['title']; ?>
        </div>
        
        <div class="uk-coach-block-price">
            <?php echo $fieldContent['field_price']; ?>
        </div>
        
        <div class="uk-coach-block-text">
            <?php echo $fieldContent['body']; ?>
        </div>
        
        <div class="uk-coach-block-btn">  
            <a class="uk-bordered-remove" href="#modal-block-<?php echo $fieldContent['nid'];?>" data-toggle="modal" >  
                <?php echo t('Записаться'); ?>        
            </a>
        </div>
    </div>
    
    <div id="modal-block-<?php echo $fieldContent['nid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="event-modal-label" aria-hidden="true">
    
        <div class="modal-dialog">
			<div class="modal-content uk-black-modal-content">
                <div class="uk-coach-block-stars">
                    <?php if($numberOfStars > 0){ ?>
                        <?php for($i = 0; $i < $numberOfStars; $i++){ ?>
                            <span class="uk-coach-block-stars-star icon-favorite"></span> 
                        <?php } ?>
                    <?php } ?>
                </div> 
                <div class="uk-coach-block-modal-title">
                    <?php echo $fieldContent['title']; ?>
                </div>
                
                <div class="uk-coach-block-price">
                    <?php echo $fieldContent['field_price']; ?>
                </div>
                
                <div class="uk-coach-block-text">
                    <?php echo $fieldContent['body']; ?>
                </div>
                
                <form id="modal-form-<?php echo $fieldContent['nid'];?>" class="uk-modal-form row" action="<?php echo $formAction; ?>" method="post"> 
					
                    <div class="col-md-4">
                        <input class="uk-name uk-form-control" type="text" name="name" placeholder="Фио" required/>
                    </div>
                    
                    <div class="col-md-4">
                        <input class="uk-phone uk-form-control" type="text" name="phone" placeholder="Телефон" required/>
                    </div>
                    
                    <div class="col-md-4">
                        <input class="uk-email uk-form-control" type="email" name="email" placeholder="Email" required/>
                    </div>
					
					<input class="uk-subject"  type="hidden" name="subject" value="<?php echo $fieldContent['title']; ?>"/>
					<input type="hidden" name="check"/>
                        
					<input type="hidden" name="payee_id" value="10862" />
					<input type="hidden" name="shop_order_number" value="<?php echo $orderNumber;?>" />
					<input type="hidden" name="bill_amount" value="<?php echo $fieldContent['field_price'];?>"/>
					<input type="hidden" name="description" value="<?php echo $fieldContent['title'];?>"/>
					<input class="uk-success-url" type="hidden" name="success_url" value="<?php echo $currentUrlSuccess;?>" />
					<input class="uk-failed-url" type="hidden" name="failure_url" value="<?php echo $currentUrlFailed;?>" />
					<input type="hidden" name="encoding" value="utf-8"/>
					<input type="hidden" name="lang" value="ru" />
                    
                    <div class="uk-text-center">	
                        <button class="uk-mod-pay-button">Оплатить</button>
                        <span class="uk-success-pay-message">
                            Оплата произведена успешно!
                        </span>
                        <span class="uk-failed-pay-message">
                            Ошибка, оплата не была произведена.
                        </span>
                    </div>
				</form>
            </div>
        </div>
    </div>
