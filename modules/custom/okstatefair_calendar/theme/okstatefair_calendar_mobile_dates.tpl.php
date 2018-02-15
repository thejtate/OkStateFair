<div class="nav-dropdown nav-top">
  <a href="#" class="btn-dropdown"><?php print $data['title_date'];?></a>
  <div class="nav-dropdown-inner">
    <div class="table-calendar-wrapper">
      <table class="table-calendar">
        <thead>
        <tr>
          <th>S</th>
          <th>M</th>
          <th>T</th>
          <th>W</th>
          <th>T</th>
          <th>F</th>
          <th>S</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td colspan="4"><span class="text"><?php print t('September'); ?></span></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-14', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-15', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-16', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
        </tr>
        <tr>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-17', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-18', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-19', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-20', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-21', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-22', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-23', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
        </tr>
        <tr>
          <td><?php print theme('okstatefair_calendar_mobile_date_link', array('current_date' => '2017-09-24', 'active_date' => $data['date'], 'category' => $data['current_category']))?></td>
          <td colspan="6"><span class="text"><?php print t('Select a day to see events'); ?></span></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>