<?php
/**
 * @file
 * Template to display a view as a calendar month.
 * 
 * @see template_preprocess_calendar_month.
 *
 * $day_names: An array of the day of week names for the table header.
 * $rows: An array of data for each day of the week.
 * $view: The view.
 * $calendar_links: Array of formatted links to other calendar displays - year, month, week, day.
 * $display_type: year, month, day, or week.
 * $block: Whether or not this calendar is in a block.
 * $min_date_formatted: The minimum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $max_date_formatted: The maximum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $date_id: a css id that is unique for this date, 
 *   it is in the form: calendar-nid-field_name-delta
 * 
 */
//dsm('Display: '. $display_type .': '. $min_date_formatted .' to '. $max_date_formatted);
?>
<?php 
    //количество месяцев в году
    define('NUM_OF_MONTH', 12);
    //количество выводимых месяцев от центрального, формула 3+1 центральный+3 итого 7 месяцев
    define('NUM_OF_CENTER', 3);
    
    //Получение текущих значений даты
    $currentDate = explode(',', date('d,m,Y'));
    $currenDay = $currentDate[0];
    $currentMonth = $currentDate[1];
    $currentYear = $currentDate[2];
    
    //Получение текущих значений url
    $requestUrl = base_path().request_path();
    $currentCalendarPage = $currentYear . '-' . $currentMonth;
    $queryParams = drupal_get_query_parameters();
    if(isset($queryParams['mini'])){
        $calendarPage = $queryParams['mini'];
        $calendarDate = explode('-', $queryParams['mini']);
        $calendarYear = intval($calendarDate[0]);
        $calendarMonth = intval($calendarDate[1]);
    } else {
        $calendarPage = $currentCalendarPage;
        $calendarYear = intval($currentYear);
        $calendarMonth = intval($currentMonth);
    }
    
    //составление списка месяцев
    $monthArray = array(
        1 => array(
            'number' => '01', 
            'name' => t('January')
        ),
        2 => array(
            'number' => '02', 
            'name' => t('February')
        ),
        3 => array(
            'number' => '03', 
            'name' => t('March')
        ),
        4 => array(
            'number' => '04', 
            'name' => t('April')
        ),
        5 => array(
            'number' => '05', 
            'name' => t('May')
        ),
        6 => array(
            'number' => '06', 
            'name' => t('June')
        ),
        7 => array(
            'number' => '07', 
            'name' => t('July')
        ),
        8 => array(
            'number' => '08', 
            'name' => t('August')
        ),
        9 => array(
            'number' => '09', 
            'name' => t('September')
        ),
        10 => array(
            'number' => '10', 
            'name' => t('October')
        ),
        11 => array(
            'number' => '11', 
            'name' => t('November')
        ),
        12 => array(
            'number' => '12', 
            'name' => t('December')
        )
    );
	
    //Получаем начало и конец относительно выбраного месяца
    $startNumber = $calendarMonth - NUM_OF_CENTER;
    $endNumber = $calendarMonth + NUM_OF_CENTER;
    
    //проверка на выход за пределы массива в начале или вконце
    $offsetStart = NUM_OF_MONTH - NUM_OF_CENTER;
    $offsetEnd = NUM_OF_CENTER;
    $offset = NUM_OF_MONTH - $calendarMonth;
    $offsetStartFlag = false;
    $offsetEndFlag = false;
    
    //если выход за пределы массива в начале
    if($offset >= $offsetStart){
        $offsetStartFlag = true;
        $offsetStartMonths = NUM_OF_MONTH + ($calendarMonth - NUM_OF_CENTER);
    } 
    
    //если выход за пределы массива в вконце
    if($offset <= $offsetEnd){
        $offsetEndFlag = true;
        $offsetEndMonths = ($calendarMonth + NUM_OF_CENTER) - NUM_OF_MONTH;
    }
	
    //Формирование ссылок вперед и назад
    if ($calendarMonth == NUM_OF_MONTH){
        $nextLink = $requestUrl.'?mini=' . ($calendarYear + 1) . '-01';
        $prevLink = $requestUrl.'?mini=' . ($calendarYear) . '-'.$monthArray[$calendarMonth-1]['number'];
    } else if ($calendarMonth == 1){
        $prevLink = $requestUrl.'?mini=' . ($calendarYear - 1) . '-12';
        $nextLink = $requestUrl.'?mini=' . ($calendarYear) . '-'.$monthArray[$calendarMonth+1]['number'];
    } else{
        $prevLink = $requestUrl.'?mini=' . ($calendarYear) . '-'.$monthArray[$calendarMonth-1]['number'];
        $nextLink = $requestUrl.'?mini=' . ($calendarYear) . '-'.$monthArray[$calendarMonth+1]['number'];
    }
?>
<div class="calendar-calendar uk-calendar">
    <div class="container uk-calendar-pager-container">
        <a class="uk-calendar-prev uk-bordered-remove icon-left-arrow2" href="<?php echo $prevLink;?>"></a>
        
        <a class="uk-calendar-next uk-bordered-remove icon-right-arrow" href="<?php echo $nextLink;?>"></a>
        
        <ul class="uk-calendar-pager">
            
            <?php if($offsetStartFlag){?>
                <?php for($i = $offsetStartMonths; $i <= NUM_OF_MONTH; $i++){ ?>
                    <li>
                        <a class="uk-calendar-month" href="<?php echo $requestUrl.'?mini=' . ($calendarYear - 1) . '-' . $monthArray[$i]['number']; ?>"><?php echo $monthArray[$i]['name'];?> <span class="uk-calendar-month-year"><?php echo $calendarYear - 1;?></span></a>    
                    </li>
                <?php } ?>
            <?php } ?>
            <?php for ($i = $startNumber; $i <= $endNumber; $i++){ ?>
                <?php if (($i > 0) && ($i <= NUM_OF_MONTH)){
                        if ($calendarPage == $calendarYear . '-' . $monthArray[$i]['number']){
                            $monthClass = ' class="uk-month-active"';
                        } else $monthClass = '';
                ?>
                    <li<?php echo $monthClass; ?>>
                        <a class="uk-calendar-month" href="<?php echo $requestUrl.'?mini=' . $calendarYear . '-' . $monthArray[$i]['number']; ?>"><?php echo $monthArray[$i]['name'];?> <span class="uk-calendar-month-year"><?php echo $calendarYear;?></span></a>    
                    </li>
                <?php } ?>
            <?php } ?>
            <?php if($offsetEndFlag){?>
                <?php for($i = 1; $i <= $offsetEndMonths; $i++){ ?>
                    <li>
                        <a class="uk-calendar-month" href="<?php echo $requestUrl.'?mini=' . ($calendarYear + 1) . '-' . $monthArray[$i]['number']; ?>"><?php echo $monthArray[$i]['name'];?> <span class="uk-calendar-month-year"><?php echo $calendarYear + 1;?></span></a>    
                    </li>
                <?php } ?>
            <?php } ?>
            
        </ul>
    </div>
    <div class="month-view">
        <div class="container">
            <div class="row">
              <?php foreach ($day_names as $id => $cell): ?>
                <div class="uk-calendar-coll uk-calendar-header <?php print $cell['class']; ?>" id="<?php print $cell['header_id'] ?>">
                  <?php print $cell['data']; ?>.
                </div>
              <?php endforeach; ?>
            </div>
            <div class="row">
                <?php 
                    foreach ((array) $rows as $row) {
                        print $row['data'];
                    } ?>
            </div>
        </div>
    </div>
</div>