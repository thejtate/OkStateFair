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
//'img_logo-delta.png','img_logo-okl-bank.png',
?>
<iframe name=print_frame width=0 height=0 frameborder=0 src=about:blank style="display: none;"></iframe>
<footer class="footer">
<div class="agenta-wrapper mobile">
<a href="#" class="btn-menu-agenta"><span class="text-agenta">AGENDA</span></a>
<div class="content-agenta">
<div id="mobile-menu-agenta" class="menu-agenta">
<div class="menu-items-wrapper">
</div>
</div>
  <div class="ajax-loader">
    <div class="circular">
      <div class="circularG circularG_1">
      </div>
      <div class="circularG circularG_2">
      </div>
      <div class="circularG circularG_3">
      </div>
      <div class="circularG circularG_4">
      </div>
      <div class="circularG circularG_5">
      </div>
      <div class="circularG circularG_6">
      </div>
      <div class="circularG circularG_7">
      </div>
      <div class="circularG circularG_8">
      </div>
    </div>
  </div>
<div class="btn-group">
  <div class="btn-left"><a href="#" class="agenda-share">SHARE</a>
    <div class="wrapper-share-wrapper">
      <ul class="list-share">
        <li class="item-twitter">
          <a href="#" data-opener="allow-propagation"></a>
        </li>
        <li class="item-facebook">
          <a href="#" data-opener="allow-propagation"></a>
        </li>
        <li class="item-mail">
          <a href="#" data-opener="allow-propagation"></a>
        </li>
      </ul>
    </div>
    <div class="share-ajax-loader">
      <div class="circular">
        <div class="circularG circularG_1">
        </div>
        <div class="circularG circularG_2">
        </div>
        <div class="circularG circularG_3">
        </div>
        <div class="circularG circularG_4">
        </div>
        <div class="circularG circularG_5">
        </div>
        <div class="circularG circularG_6">
        </div>
        <div class="circularG circularG_7">
        </div>
        <div class="circularG circularG_8">
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="empty-agenda">
    <div class="empty-img">

    </div>
    <div class="empty-text">
      To add events to your Agenda, simply press “Add to Agenda” next to an event and it will populate in this box.
    </div>
  </div>
</div>
</div>
  <div class="btn-full-wrapper">
    <?php print l('<span class="text">' . t('BUY TICKETS') . '</span>', variable_get('tickets', ''), array('html' => TRUE, 'external' => TRUE, 'attributes' => array('class' => array('btn-full-buy')))); ?>
  </div>
</footer>