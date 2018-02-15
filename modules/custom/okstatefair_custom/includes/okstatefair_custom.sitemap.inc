<?php
/**
 * Site map Page callback
 * @return string
 * HTML
 */
function okstatefair_custom_site_map_page() {
  return theme('okstatefair_site_map_page',
    array(
      'sf_menu' => okstatefair_custom_site_map_menu('menu-state-fair', TRUE),
      'sfp_menu' => okstatefair_custom_site_map_menu('menu-state-fair-park', TRUE),
      'resources_menu' => okstatefair_custom_site_map_menu('menu-footer'))
  );
}

/**
 * Return rendered menu tree
 * @param $menu
 * @param bool $start_with_root_level
 *  special wrapers for top level links if true
 * @return string
 */
function okstatefair_custom_site_map_menu($menu, $start_with_root_level = FALSE) {
  $menu = menu_tree_all_data($menu);
  return okstatefair_custom_site_map_menu_render_recursive($menu, $start_with_root_level);
}

/**
 * Recursive function for rendering menu tree
 * @param $menu
 * @param bool $root_level
 * @return string
 */
function okstatefair_custom_site_map_menu_render_recursive($menu, $root_level = FALSE) {
  $blocked_nodes = array('<front>', 'node/' . COMING_SOON_SFP, 'node/' . COMING_SOON_SFP2, 'node/' . COMING_SOON);
  if ($root_level) {
    $content = '';
    foreach ($menu as $key => $link) {
      if (!$link['link']['hidden']) {
        $content .= '<div class="block-item">';
        if (isset($link['below']) && !empty($link['below'])) {
          $check = array_values($link['below']);
          $blocked_nodes[] = $check['0']['link']['link_path'];
          if (!in_array($link['link']['link_path'], $blocked_nodes))
            $content .= '<h5>' . l(strip_tags($link['link']['title']), $link['link']['link_path'], array('html' => TRUE)) . '</h5>';
          else
            $content .= '<h5>' . strip_tags($link['link']['title']) . '</h5>';
          $content .= okstatefair_custom_site_map_menu_render_recursive($link['below']);
        }
        else
        if (!in_array($link['link']['link_path'], $blocked_nodes))
          $content .= '<h5>' . l(strip_tags($link['link']['title']), $link['link']['link_path'], array('html' => TRUE)) . '</h5>';
        else
          $content .= '<h5>' . strip_tags($link['link']['title']) . '</h5>';
        $content .= '</div>';
      }
    }

  } 
  else {
    $content = '<ul>';
    foreach ($menu as $key => $link) {
      if (!$link['link']['hidden']) {
        $content .= '<li>';
        $link_classes = isset($link['below']) && !empty($link['below']) ? array('has-submenu') : array();
        if (empty($link_classes) && !in_array($link['link']['link_path'], $blocked_nodes))
          if ($link['link']['title'] != 'Newsletter')
            $content .= l(strip_tags($link['link']['title']), $link['link']['link_path'], array('html' => TRUE));
          else  $content .= ctools_modal_text_button($link['link']['title'], $link['link']['link_path'], 'ctools-modal-modal-popup-medium', 'text ctools-modal-modal-popup-medium');
        else 
          $content .= '<span class="' . $link_classes[0] . '">' . strip_tags($link['link']['title']) . '</span>';
        if (isset($link['below']) && !empty($link['below'])) {
          $content .= okstatefair_custom_site_map_menu_render_recursive($link['below']);
        }
        $content .= '</li>';
      }
    }
    $content .= '</ul>';
  }
  return $content;
}