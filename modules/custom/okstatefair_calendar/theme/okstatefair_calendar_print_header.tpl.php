<h2>
<?php
  if(!empty($data['date'])):
    print  $data['date'];
  endif;
?>
</h2>
<h2>
  <?php print t('Categories:');?>&nbsp;
<?php
  if(!empty($data['categories'])):
    print $data['categories'];
  endif;
?>
</h2>