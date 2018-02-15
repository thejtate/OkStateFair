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
$form['submitted']['enter_question_or_comment_here']['extra']['attributes']['class'][] = 'form-item form-type-textarea';
?>
<?php
// Print out the main part of the form.
// Feel free to break this up and move the pieces within the array.
// print drupal_render($form['submitted']);
hide($form['submitted']['first_name']);
hide($form['submitted']['last_name']);
hide($form['submitted']['email_address']);
// Always print out the entire $form. This renders the remaining pieces of the
// form that haven't yet been rendered above.
?>
<div class="form-header">
  <fieldset>
    <div class="form-field-user-information">
      <?php print render($form['submitted']['name']); ?>
      <?php print render($form['submitted']['e_mail']); ?>
    </div>
    <div class="form-field-question">
      <?php print render($form['submitted']['enter_question_or_comment_here']); ?>
    </div>
  </fieldset>
  <div class="image"><?php print theme('image', array('path' => path_to_theme() . '/images/logo-state-fair-2.jpg')); ?></div>
</div>           
<div class="form-footer">
  <div class="form-captcha">
    <?php print render($form['captcha']); ?>
  </div> 
  <?php print render($form['actions']); ?>
</div> 
<?php print drupal_render_children($form); ?>