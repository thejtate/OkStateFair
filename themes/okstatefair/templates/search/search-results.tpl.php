<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */

if ($pager_total_items < 10 ) $pager_limits = $pager_total_items;

?>
<?php if ($search_results): ?>
  <div class="description">
    <p><?php print t('Displaying %pager_limits of %pager_total_items results for <i>%search_keyword</i>', array('%pager_total_items' => $pager_total_items, '%pager_limits' => $pager_limits, '%search_keyword' => arg(2))); ?></p>
  </div>
  
  <div class="search-result-wrapper">
    <?php print $search_results; ?>
  </div>
  <div class="pager-wrapper">
    <div class="item-list">
      <?php print $pager; ?>
    </div>
  </div>
  
<?php else : ?>
  <div class="description">
    <h2><?php print t('Your search yielded no results');?></h2>
    <?php print search_help('search#noresults', drupal_help_arg()); ?>
  </div>
<?php endif; ?>
