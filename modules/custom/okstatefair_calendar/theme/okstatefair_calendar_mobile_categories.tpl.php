<div class="fixed-nav-bottom">
  <div class="nav-dropdown nav-bottom fixed">
    <a href="#" class="btn-dropdown"><?php print $data['current_category']  == 'all' ? t('CATEGORIES') : $data['terms'][$data['current_category']]->name; ?></a>
    <div class="nav-dropdown-inner">
      <ul class="nav-dropdown-list">
        <?php $link_class = ($data['current_category'] == 'all') ? 'all-link' : '';?>
        <li><a href="<?php print url('mobile-state-fair-calendar/' . $data['date'] . '/all' )?>" class="<?php print $link_class?>">ALL</a></li>
        <?php foreach ($data['terms'] as $term):?>
          <?php $link_class = ($data['current_category'] == $term->tid) ? 'all-link' : '';?>
          <li><a href="<?php print url('mobile-state-fair-calendar/' . $data['date'] . '/' . $term->tid)?>" class="<?php print $link_class?>"><?php print $term->name?></a></li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>
</div>
