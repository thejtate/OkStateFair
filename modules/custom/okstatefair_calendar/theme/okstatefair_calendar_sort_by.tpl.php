<div class="sort-table">
  <form class="sort" action="#">
    <h3 class="title-sort"><?php print t('Sort by'); ?></h3>
    <div class="form-item-wrapper">
      <div class="form-item form-type-checkbox">
        <?php $checked = (empty($args) || in_array('all', $args)) ? ' checked' : ''; ?>
        <label for="sort-all"><?php print t('ALL'); ?></label> <input type="checkbox" id="sort-all" class="sort-by" value="all"<?php print $checked?>/>
      </div>
      <?php $i = 1;?>
      <?php $count = count($category_terms);?>
      <?php foreach($category_terms as $term):?>
        <?php $additional_class = ($i == $count) ? ' last' : '';?>
        <?php $i++?>
      <div class="form-item form-type-checkbox<?php print $additional_class;?>">
        <?php $checked = in_array($term->tid, $args) ? ' checked' : ''; ?>
        <label for="sort-<?php print $term->tid; ?>"><?php print strtoupper($term->name);?></label> <input type="checkbox" id="sort-<?php print $term->tid; ?>" class="sort-by" value="<?php print $term->tid; ?>"<?php print $checked?>/>
      </div>
      <?php endforeach;?>
    </div>
  </form>

</div>