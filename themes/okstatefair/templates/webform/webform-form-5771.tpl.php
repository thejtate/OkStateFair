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
hide($form['submitted']['description']);
// Always print out the entire $form. This renders the remaining pieces of the
// form that haven't yet been rendered above.
$webform_node = node_load(WEBFORM_GOLDEN_TICKET_NID);

if (!empty($webform_node->body)) : ?>
  <?php print $webform_node->body[LANGUAGE_NONE]['0']['value']; ?>
<?php endif;
if (!empty($form['#node']->body)) : ?>
  <?php print $form['#node']->body[LANGUAGE_NONE]['0']['value']; ?>
<?php endif; ?>
<div class="note">
  <?php print strip_tags(render($form['submitted']['description'])); ?>
</div>
<div class="form form-ticket-popup form-success">
  <div class="form-field-first-name field no-label">
    <?php print render($form['submitted']['first_name']); ?>
  </div>
  <div class="form-field-last-name field no-label">
    <?php print render($form['submitted']['last_name']); ?>
  </div>
  <div class="form-field-email field no-label">
    <?php print render($form['submitted']['email']); ?>
  </div>
  <?php print render($form['actions']['submit']); ?>
  <?php print drupal_render_children($form); ?>
</div>
