<?php

/**
 * Implements hook_views_plugins().
 */
function views_exposed_pager_views_plugins() {
  return array(
    'pager' => array(
      'views_exposed_pager' => array(
        'title' => t('Paged output, full pager with items per page select'),
        'short title' => t('Full with items per page, exposed pager'),
        'help' => t('Paged output, full pager with items per page select'),
        'handler' => 'views_exposed_pager_plugin',
        'help topic' => 'pager-full',
        'uses options' => TRUE,
      ),
      'views_exposed_pager_lite' => array(
        'title' => t('Paged output, lite pager with items per page select'),
        'short title' => t('Lite pager with items per page, exposed pager'),
        'help' => t('Paged output, lite pager with items per page select'),
        'handler' => 'views_exposed_pager_plugin_lite',
        'help topic' => 'pager-lite',
        'uses options' => TRUE,
        'parent' => 'full',
      ),
    ),
  );
}
