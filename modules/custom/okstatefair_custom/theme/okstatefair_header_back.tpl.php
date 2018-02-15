<?php
/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */

?>
<header class="header">
  <div class="wrapper">
    <a href="/#oklahoma-state-fair" class="logotype">
      <div class="logo"></div>
      <div class="type">
        <h1><?php print t('OKLAHOMA'); ?></h1>
        <h2><?php print t('State Fair'); ?></h2>
      </div>
    </a>
<!--     <div class="golden-ticket golden-header">-->
<!--       <div class="show-off">-->
<!--           --><?php //print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/sparkl.png')); ?>
<!--       </div>-->
<!--       --><?php //print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/GoldenTicket.png')); ?>
<!--     </div>-->
      <div class="top-buttons">
      <ul>
        <li class="btn-search">
          <a href="#" class="btn" >SEARCH</a>
            <?php print $search; ?>
        </li>
        <li class="btn-tickets">
          <?php print $tickets_link ? $tickets_link : ''; ?>
        </li>
        <li class="btn-food-finder">
          <?php print $foodfinder_link ? $foodfinder_link : ''; ?>
        </li>
        <li class="btn-newsletter">
          <?php print $newsletter_link ? $newsletter_link : ''; ?>
        </li>
        <?php if (isset($mobile_app_link) && !empty($mobile_app_link)) : ?>
          <li class="btn-app-mobile">
            <?php print $mobile_app_link; ?>
          </li>
        <?php endif; ?>
      </ul>
    </div>
    <div id="countdown">
      <div class="countdown-inner"></div>
    </div>
    <nav class="navigation">
      <div class="block-left">
         <div class="block-inner"><?php print theme('image', array('path' => drupal_get_path('theme',$GLOBALS['theme']) . '/images/tmp/_img_title_date_2017.png')); ?></div>
      </div>
     <?php  print($items); ?>
    </nav>
  </div>
</header>