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
    //Получение текущих значений даты
    $currenDate = split(',', date('d,m,Y'));
    $currenDay = $currenDate[0];
    $currenMonth = $currenDate[1];
    $currenYear = $currenDate[2];
    
    //Получение текущих значений url
    $requestUrl = base_path().request_path();
    //$queryParams = drupal_get_query_parameters();
    $currentUrl = $requestUrl.'?mini=' . $currenYear . '-' . $currenMonth;
    
    //составление списка месяцев
    $monthArray = array(
        '01'  => t('January'),
        '02'  => t('February'),
        '03'  => t('March'),
        '04'  => t('April'),
        '05'  => t('May'),
        '06'  => t('June'),
        '07'  => t('July'),
        '08'  => t('August'),
        '09'  => t('September'),
        '10' => t('October'),
        '11' => t('November'),
        '12' => t('December')
    );
?>
    <ul class="pager uk-calendar-pager">
        <?php foreach ($monthArray as $k=>$month) {?>
            <li class="">
                <a href="<?php echo $requestUrl.'?mini=' . $currenYear . '-' . $k; ?>"><?php echo $month;?></a>    
            </li>
        <?php } ?>
        
        <li class="">
            <a href="/blizhayshie-meropriyatiya?mini=2016-08" title="Navigate to next month" rel="nofollow">Next »</a>
        </li>
    </ul>
        
<div class="calendar-calendar uk-calendar">
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
<script>
/*
try {
  // ie hack to make the single day row expand to available space
  if ($.browser.msie ) {
    var multiday_height = $('tr.multi-day')[0].clientHeight; // Height of a multi-day row
    $('tr[iehint]').each(function(index) {
      var iehint = this.getAttribute('iehint');
      // Add height of the multi day rows to the single day row - seems that 80% height works best
      var height = this.clientHeight + (multiday_height * .8 * iehint); 
      this.style.height = height + 'px';
    });
  }
}catch(e){
  // swallow 
}
*/
</script>