<?php

/**
 * @file
 * Customize confirmation screen after successful submission.
 *
 * This file may be renamed "webform-confirmation-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-confirmation.tpl.php" to affect all webform confirmations on your
 * site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $confirmation_message: The confirmation message input by the webform author.
 * - $sid: The unique submission ID of this submission.
 */
// get contact webform
$block = module_invoke('webform', 'block_view', 'webform-client-form-' . WEBFORM_GOLDEN_TICKET_NEWSLETTER_NID);
?>
<div class="webform-confirmation">
    <h3>SUCCESS!</h3>
    <?php if ($confirmation_message): ?>
        <?php print $confirmation_message; ?>
    <?php else: ?>
        <p><?php print t('Thank you, your submission has been received.'); ?></p>
    <?php endif; ?>

    <div class="form form-ticket-popup form-success">
        <?php print render($block['content']); ?>
    </div>
    <div
        class="img"><?php print theme('image', array('path' => path_to_theme() . "/images/tmp/2017-logo_1.png")); ?></div>
</div>