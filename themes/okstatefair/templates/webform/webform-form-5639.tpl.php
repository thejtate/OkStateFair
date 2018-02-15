<?php
/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 */
?>
<?php
// Print out the main part of the form.
// Feel free to break this up and move the pieces within the array.
// print drupal_render($form['submitted']);
hide($form['actions']);
// Always print out the entire $form. This renders the remaining pieces of the
// form that haven't yet been rendered above.
?>
<?php if (!empty($form['#node']->body)) {
  print $form['#node']->body[LANGUAGE_NONE]['0']['value'];
} else if (isset($form['#node']->still_visible)) {
  print '<p>' . $form['#node']->still_visible . '</p>';
} ?>
<div
    class="img"><?php print theme('image', array('path' => path_to_theme() . '/images/tmp/img-golden-ticket.png')); ?></div>
<div class="form form-ticket-popup form-golden-ticket">
    <div class="note">
        <?php print strip_tags(render($form['submitted']['description'])); ?>
    </div>
    <div class="form-field-first-name field no-label">
        <?php print render($form['submitted']['first_name']); ?>
    </div>
    <div class="form-field-last-name field no-label">
        <?php print render($form['submitted']['last_name']); ?>
    </div>
    <div class="form-field-email field no-label">
        <?php print render($form['submitted']['email']); ?>
    </div>
    <div class="form-field-address field no-label">
        <?php print render($form['submitted']['address']); ?>
    </div>
    <div class="form-field-city field no-label">
        <?php print render($form['submitted']['city']); ?>
    </div>
    <div class="form-field-state field no-label">
        <?php print render($form['submitted']['state']); ?>
    </div>
    <div class="form-field-zip field no-label">
        <?php print render($form['submitted']['zip_code']); ?>
    </div>
    <?php print render($form['actions']['submit']); ?>
    <?php print drupal_render_children($form); ?>
</div>
