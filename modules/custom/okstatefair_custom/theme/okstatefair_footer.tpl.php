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
$logos = array('amd.png', 'theoklahoman.png', 'att.png', 'bankfirst.png', 'AquaFirm.png', 'AmericInn.png', 'renewalbyanderson.png', 'bankofwesternoklahoma.png', 'american_fidelity.png', 'frankfurt_short_bruza.png', 'waste_connections.png','bankoklahoma.png', 'chickasaw_adventure.png', 'coors.png', 'deltadental.png', 'dodge.png', 'embassy.png', 'farmcredit.png', 'hobbylobby.png', 'mattressfirm.png', 'midfirst.png', 'oge.png', 'selectcomfort.png', 'touchstone.png', 'westbay.png', 'wyndham.png', 'furniturefirm.png', 'Inn.png', 'verison-small.png', 'comfortdental.png', 'loves.png','bathfitter.png','jleco.png','rem.png','tsse.png');
$first_slide = array('logo_home_d_pepper.png');
$theme_path = base_path() . drupal_get_path('theme', 'okstatefair');
?>
<div class="footer-type-2">
  <div class="inner">
    <div class="wrapp-logo-footer">
      <div class="carousel-fader" data-control="block_slider_fader">
        <ul class="fade-logos">
          <?php foreach ($first_slide as $k => $v) : ?>
            <li class="logo">
              <?php print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/' . $v)); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="icons carousel-min-logo logo-footer">
        <span class="shadow-icon-left"></span>
        <span class="shadow-icon-right"></span>
        <div class="inner-carousel-min" data-control="block_slider_mover">
          <ul class="logo-carousel" data-role="block_slider_mover_slides">
            <?php foreach ($logos as $k => $v) : ?>
              <li class="carousel-item">
                <?php print theme('image', array('path' => drupal_get_path('theme', 'okstatefair') . '/images/' . $logos[$k])); ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    <?php print get_social_links(); ?>
    <nav class="footer-navigation">
      <?php print($items); ?>
    </nav>

  </div>

    <div class="logo">
      <?php $mobileapplication_url = variable_get('mobileapplication_url', ''); ?>
      <?php if (!empty($mobileapplication_url)) : ?>
        <?php print l(theme('image', array('path' => $theme_path . '/images/tmp/stacked-mobile-app.png')), $mobileapplication_url, array('external' => TRUE, 'html' => TRUE, 'attributes' => array('target' => '_blank'))); ?>
      <?php endif; ?>
      <?php $footer_logo = variable_get('footer_large', ''); ?>
      <?php if (!empty($footer_logo)) : ?>
        <?php print l(theme('image', array('path' => $theme_path . '/images/logo-min-NEW.png')), $footer_logo, array('external' => TRUE, 'html' => TRUE, 'attributes' => array('target' => '_blank'))); ?>
      <?php endif; ?>
    </div>
</div>
<?php print l('<div class="inner"><div class="arrow"></div></div>', '/#state-fair-park', array('html' => TRUE, 'external' => TRUE, 'attributes' => array('class' => array('btn-full-right-1')))); ?>

