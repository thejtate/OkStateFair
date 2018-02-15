<div class="calendar-one-line <?php print $cl ? $cl : ''; ?>">

  <ul class="calendar-items">
    <?php $i = 0;?>
    <?php $count = count($data)?>
    <?php foreach($data as $item):?>
      <?php $additional_classes = '';
      $additional_classes .= (($item['active']) ? ' active' : '');
      $additional_classes .= (($i == 0) ? ' first': '');
      $additional_classes .= (($i == $count - 1) ? ' last' : '');
      $i++;
      ?>
      <li class="event-date<?php print $additional_classes;?>">
        <?php if($item['active'] && !empty($item['header_data'])):?>
                <div class="calendar-header">
                  <ul class="calendar-header-items">
                    <?php $j = 0;?>
                    <?php $count_header = count($item['header_data']);?>
                    <?php foreach($item['header_data'] as $header_item):?>
                    <?php
                      $header_classes = (($j == 0) ? ' first': '');
                      $header_classes .= (($j == $count_header - 1) ? ' last' : '');
                      $j++;
                    ?>
                    <li class="item-event<?php print $header_classes;?>">
                      <strong><span class="time"><?php print $header_item['red'];?></span><span class="text-event"><?php print $header_item['black'];?></span></strong></li>
                    <?php endforeach;?>
                  </ul>
                </div>
        <?php endif;?>
        <div class="content-event">
          <?php if ($item['active']): ?>
          <?php if (!empty($item['header_data'])): ?>
            <i class="icon-arrow icon-arrow-top"></i>
          <?php endif; ?>
            <?php if (!empty($item['footer_image'])): ?>
              <i class="icon-arrow icon-arrow-bottom"></i>
            <?php endif; ?>
          <?php endif; ?>
          <span class="title"><?php print $item['day_of_week'];?></span> <a href="<?php print url('state-fair-calendar/' . $item['redirect_data'] . '/all')?>" class="num" data="<?php print $item['redirect_data']?>"><?php print $item['day']?></a>
          <?php if (!empty($item['edit_link'])): ?>
            <?php print $item['edit_link'];?>
          <?php endif; ?>
        </div>
        <?php if($item['active'] && !empty($item['footer_image'])):?>
        <div class="calendar-footer">
          <?php print $item['footer_image'];?>
        </div>
        <?php endif;?>
      </li>
    <?php endforeach;?>
  </ul>

</div>