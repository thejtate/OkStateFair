<?php
/**
 * Mobile menu Page callback
 * @return string
 * HTML
 */
function okstatefair_custom_mobile_menu_page() {
  return theme('okstatefair_mobile_menu_page',
    array(
      'sf_menu' => okstatefair_custom_mobile_menu('menu-mobile-sf'),
      'sfp_menu' => okstatefair_custom_mobile_menu('menu-mobile-sfp'))
  );
}

/**
 * Return rendered menu tree
 * @param $menu
 *  special wrapers for top level links if true
 * @return string
 */
function okstatefair_custom_mobile_menu($menu) {
  $menu = menu_tree_all_data($menu);
  return okstatefair_custom_links_menu_render_recursive($menu);
}

/**
 * Recursive function for rendering menu tree
 * @param $menu
 * @param bool $root_level
 * @return string
 */
function okstatefair_custom_links_menu_render_recursive($menu) {
  $content = '';
  foreach ($menu as $key => $link) {

    if (!$link['link']['hidden']) {
      $full_title = explode(' -- ', $link['link']['title']);
      $title_link = l($link['link']['title'], $link['link']['href']);

      if (count($full_title) >= 2) {

        if ($full_title['1'] == 'Not editable') {
          $title_link = '<span>' . $link['link']['title'] . '</span>';
        }
        elseif ($full_title['1'] != 'hide') {
          $title_link = l($link['link']['title'], $link['link']['href']);

        }
        else {
          $title_link = '';
        }
      }
      if (!empty($title_link)) {
        $content .= '<li>';
        if (isset($link['below']) && !empty($link['below'])) {

          $content .= $title_link;
          $content .= okstatefair_custom_links_menu_render_recursive($link['below']);
        }
        else {
          $content .= $title_link;
        }
        $content .= '</li>';
      }
      else {
        if (isset($link['below']) && !empty($link['below'])) {
          $content .= '<li>';
          $content .= okstatefair_custom_links_menu_render_recursive($link['below']);
          $content .= '</li>';
        }
      }
    }
  }

  return '<ul>' . $content . '</ul>';
}