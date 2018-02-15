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
 hide($form['submitted']['first_name']);
 hide($form['submitted']['last_name']);
 hide($form['submitted']['email_address']);
 hide($form['submitted']['sign']);
 hide($form['submitted']['group']);
 // Always print out the entire $form. This renders the remaining pieces of the
// form that haven't yet been rendered above.
?>

<!--<div class="form-item webform-component webform-component-radios" id="webform-component-sign">-->
  <?php //print render($form['submitted']['sign']); ?>
<!--</div>-->
<div class="form-item webform-component webform-component-textfield form-title">
  <?php print render($form['submitted']['title']); ?>
</div>
<div class="form-item webform-component webform-component-textfield form-group-description">
  <?php print render($form['submitted']['group']['group_description']); ?>
</div>
<div class="form-item webform-component webform-component-checkboxes form-group-checkboxes">
  <?php print render($form['submitted']['group']['subgroups']); ?>
</div>

<div class="form-item webform-component webform-component-textfield form-name">
  <?php print render($form['submitted']['first_name']); ?>
</div>
<div class="form-item webform-component webform-component-textfield form-last-name">
  <?php print render($form['submitted']['last_name']); ?>
</div>
<div class="form-item webform-component webform-component-textfield form-city">
  <?php print render($form['submitted']['city']); ?>
</div>
<div class="form-item webform-component webform-component-select form-select">
  <?php print render($form['submitted']['state']); ?>
</div>
<div class="form-item webform-component webform-component-textfield form-zip">
  <?php print render($form['submitted']['zip']); ?>
</div>
<div class="form-item webform-component webform-component-email form-email">
  <?php print render($form['submitted']['email_address']); ?>
</div>
<?php print drupal_render_children($form); ?>