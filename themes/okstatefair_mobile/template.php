<?php

/**
 * @file
 * template.php
 *
 * Contains theme override functions and preprocess functions for the theme.
 */
define('STATE_FAIR_NID', 420);
define('STATE_FAIR_PARK_NID', 801);
define('RV_PARK_NID', 2302);
define('TICKET_OFFICE_NID', 1961);
//define('GENERAL_INFO_NID', 3794);
define('GENERAL_INFO_NID', 11569);
define('PARKING_NID', 2352);
define('THINGS_TO_DO_NID', 3789);
define('XTREME_ELI', 2194);
define('BANDSHEL', 2248);
define('FFF', 1548);
define('OHIIO', 2244);
define('SFP_MAP_NID', 3034);
define('SF_MAP_NID', 3033);
define('OKSTATEFAIR_MOBILE_SF_WIFI_NID', 17559);
define('OKSTATEFAIR_MOBILE_EMPLOYMENT_NID', 2353);


$includes_path = drupal_get_path('module', 'okstatefair_custom') . '/includes/';

require_once $includes_path . 'okstatefair.special_events.inc';

/**
 * Override or insert variables into the html template.
 */
function okstatefair_mobile_preprocess_html(&$vars) {
  if ($node = menu_get_object()) {
    switch ($node->type) {
      case 'food':
        $vars['classes_array'][] = 'page-sf';
        $vars['classes_array'][] = 'loading';
        $vars['classes_array'][] = 'page-promo';
        break;
      case 'homesubpark':
        $vars['classes_array'][] = 'page-sfp';
        break;
      case 'homesub':
        $vars['classes_array'][] = 'page-sf';
        break;
      case 'feed_bedding':
      case 'rvpark':
      case 'ticket_office':
      case 'general':
      case 'content_links':
        $vars['classes_array'][] = 'page-sfp';
        $vars['classes_array'][] = 'loading';
        break;
      case 'wifi_ad':
        if ($node->nid == OKSTATEFAIR_MOBILE_SF_WIFI_NID) {
          $vars['classes_array'][] = 'page-sf';
        }
        else {
          $vars['classes_array'][] = 'page-sfp';
        }
        $vars['classes_array'][] = 'page-wifi';
        break;
      case 'contact':
      case 'hours_admissions':
      case 'menu_subpage':
      case 'barnyard':
      case 'sf_space_sales':
      case 'employment';
      case 'dr_pepper':
      case 'parking':
      case 'general_sf':
        $vars['classes_array'][] = 'page-sf';
        $vars['classes_array'][] = 'loading';
        break;
      case 'state_fair_event':
        $vars['classes_array'][] = 'page-sf';
        $vars['classes_array'][] = 'loading';
        if ($node->nid == DISNEP_NID) {
          $vars['classes_array'][] = 'page-disney';
        }
        if ($node->nid == XTREME_CLAY || $node->nid == XTREME_ELI || $node->nid == XTREME_JN
          || $node->nid == XTREME_BULLS || $node->nid == XTREME_MONTGOMERY_GENTRY || $node->nid == XTREME_ELI_YOUNG_BAND || $node->nid == XTREME_NEW) {
          $vars['classes_array'][] = 'page-extreme';
          $vars['classes_array'][] = 'page-promo';
        }

        if (in_array($node->nid, chickasaw_nodes()) || _okstate_special_performer($node)) {
          $vars['classes_array'][] = 'page-promo';
        }
        break;
    }
  }
  else {
    if (in_array('html__food_finder', $vars['theme_hook_suggestions'])) {
      $vars['classes_array'][] = 'page-sf';
      $vars['classes_array'][] = 'loading';
      if (count($vars['page']['#views_contextual_links_info']['views_ui']['view']->result) == 0) {
        if (!isset($_GET['all_food']) & !isset($_GET['bacon_food']) & !isset($_GET['on-a-stick_food']) & !isset($_GET['deep-fried_food']) & !isset($_GET['gtoaf'])) {
          $vars['classes_array'][] = 'page-food_finder';
        }

      }
    } elseif (in_array('html__mobile_state_fair_calendar', $vars['theme_hook_suggestions'])) {
      $vars['classes_array'][] = 'page-sf';
      $vars['classes_array'][] = 'loading';
    } elseif(in_array('html__calendar_sfp_mobile', $vars['theme_hook_suggestions'])) {
      $vars['head_title'] = t('State Fair Park Calendar Mobile | State Fair Park');
    } elseif (in_array('html__events', $vars['theme_hook_suggestions'])) {
      $vars['classes_array'][] = 'page-sf';
      $vars['classes_array'][] = 'loading';
    }
  }

  $classes_array = array( 'page-sfp',
                          'page-sf',
                          'loading',
                          'page-promo',
                          'page-disney',
                          'page-extreme',
                          'page-calendar-sfp-mobile',
                          'node-type-state-fair-park-event',
                          'page-food_finder');

  $go_to_full = 1;
  foreach ($classes_array as $value) {
    if (in_array($value, $vars['classes_array'])) {
      $go_to_full = 0;
      break;
    }
  }

  if ($go_to_full){
    $current_url = str_replace(base_path(), '', drupal_get_path_alias(request_uri(), 1));
    if (!$current_url == '' && $_GET['q'] != 'calendar-sfp-mobile') {
      drupal_goto( $_GET['q'] , array('query' => array('device' => 'desktop')));
    }
  }
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function okstatefair_mobile_preprocess_page(&$vars, $hook) {
  if (isset($vars['node'])) {
    $node = $vars['node'];
    //$vars['site_type'][= ;
    switch ($node->type) {
      case 'homesubpark':
        if (array_key_exists('okstatefair_custom_header_sf_mobile', $vars['page']['header'])) {
          $vars['page']['header']['okstatefair_custom_header_sf_mobile']['#access'] = FALSE;
        }
        if (array_key_exists('okstatefair_custom_footer_sf_mobile', $vars['page']['footer'])) {
          $vars['page']['footer']['okstatefair_custom_footer_sf_mobile']['#access'] = FALSE;
        }
        $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp_mobile');
        $vars['page']['header']['okstatefair_custom_header_sfp_mobile']['#markup'] = $block['content'];
        $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp_mobile');
        $vars['page']['footer']['okstatefair_custom_footer_sfp_mobile']['#markup'] = $block['content'];
        break;
      case 'homesub':
        $vars['site_type'] = 'page-sf';
        break;
        case 'state_fair_event':
              if ($node->nid == XTREME_BULLS || $node->nid == XTREME_CLAY || $node->nid == XTREME_JN || 
                $node->nid == XTREME_MONTGOMERY_GENTRY || $node->nid == XTREME_ELI_YOUNG_BAND || $node->nid == XTREME_NEW) {
                $vars['pixel'] = TRUE;
              }
            break;
      //      case 'media_reference':
      //        $vars['site_type'] = 'page-type-promo';
      //        break;
      //      case 'contact':
      //        $vars['site_type'] = 'page-type-contact page-type-1 page-type-v';
      //        if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
      //          $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
      //        }
      //        if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
      //          $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
      //        }
      //        break;
      //      case 'coming':
      //        $vars['site_type'] = 'page-type-promo  page-type-coming';
      //        if (($node->nid) == COMING_SOON_SFP || ($node->nid) == COMING_SOON_SFP2) {
      //          $vars['site_type'] = 'page-type-5 page-type-coming';
      //          if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
      //            $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
      //          }
      //          if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
      //            $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
      //          }
      //          $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp');
      //          $vars['page']['header']['okstatefair_custom_header_sfp']['#markup'] = $block['content'];
      //          $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp');
      //          $vars['page']['footer']['okstatefair_custom_footer_sfp']['#markup'] = $block['content'];
      //        }
      //        break;
      //      case 'state_fair_event':
      //        $agenda_block = module_invoke('okstatefair_calendar', 'block_view', 'my_agenda');
      //        $vars['page']['header']['okstatefair_calendar_agenda']['#markup'] = $agenda_block['content'];
      //        $vars['chickasaw_nodes'] = chickasaw_nodes();
      //        $vars['site_type'] = 'page-type-1';
      //        if (in_array($node->nid, $vars['chickasaw_nodes'])) {
      //          $vars['site_type'] = 'page-type-promo navigation-sidebar-static';
      //          $vars['promo_image'] = 'logo-title-promo.png';
      //        }
      //        elseif (in_array($node->nid, private_events())) {
      //          $vars['site_type'] = 'page-type-promo page-type-custom-1 page-type-custom-concert navigation-sidebar-static';
      //          $vars['promo_image'] = 'logo_promo_custom-1.png';
      //        }
      //        else {
      //          $dest = drupal_get_destination();
      //          if (!empty($dest['destination']) && ($dest['destination'] != 'node/' . $node->nid)) {
      //            $vars['back_link'] = '<a href="' . base_path() . $dest['destination'] . '" class="btn-back"><i class="icon-btn-back"></i>' . t('FULL CALENDAR') . '</a>';
      //          }
      //          else {
      //            $vars['back_link'] = l('<i class="icon-btn-back"></i>' . t('FULL CALENDAR'), 'state-fair-calendar', array('html' => TRUE, 'attributes' => array('class' => array('btn-back'))));
      //          }
      //        }
      //        if ($node->nid == DISNEP_NID) {
      //          $vars['site_type'] = 'page-type-promo page-type-custom-1 page-type-custom-disney';
      //          $vars['back_link'] = '';
      //        }
      //        if ($node->nid == XTREME_BULLS) {
      //          $vars['site_type'] = 'page-type-promo page-type-custom-1 page-type-custom-xtremebulls';
      //          $vars['back_link'] = '';
      //          $vars['promo_image'] = 'logo_promo_custom-2.png';
      //        }
      //        break;
      case 'state_fair_park_event':
        $vars['theme_hook_suggestions'][] = 'page__state_fair_park_event';
        $vars['site_type'] = 'page-sfp';
        $dest = drupal_get_destination();
        if (!empty($dest['destination']) && ($dest['destination'] != 'node/' . $node->nid)) {
          $vars['back_link'] = '<a href="' . base_path() . $dest['destination'] . '" class="btn">' . t('FULL CALENDAR') . '</a>';
        }
        else {
          $vars['back_link'] = l(t('FULL CALENDAR'), OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_MOBILE_PAGE_PATH, array('html' => TRUE, 'attributes' => array('class' => array('btn'))));
        }
        $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp_mobile_buy_ticket');
        $vars['page']['footer']['okstatefair_custom_footer_sfp_mobile']['#markup'] = $block['content'];
        $vars['page']['footer']['okstatefair_custom_footer_sf_mobile']['#access'] = FALSE;
        $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp_mobile');
        $vars['page']['header']['okstatefair_custom_header_sfp_mobile']['#markup'] = $block['content'];
        $vars['page']['header']['okstatefair_custom_header_sf_mobile']['#access'] = FALSE;
      case 'feed_bedding':
      case 'rvpark':
      case 'ticket_office':
      case 'general':
      case 'content_links':
        //      case 'arena':
        //      case 'barns':
        //      case 'expo':
        //      case 'striped_sfp':
        //      case 'video':
        //      case 'cu':
        $vars['site_type'] = 'page-sfp loading';
        if (array_key_exists('okstatefair_custom_header_sf_mobile', $vars['page']['header'])) {
          $vars['page']['header']['okstatefair_custom_header_sf_mobile']['#access'] = FALSE;
        }
        if (array_key_exists('okstatefair_custom_footer_sf_mobile', $vars['page']['footer'])) {
          $vars['page']['footer']['okstatefair_custom_footer_sf_mobile']['#access'] = FALSE;
        }
        //        if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
        //          $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
        //        }
        //        if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
        //          $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
        //        }
        //        $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp');
        //        $vars['page']['header']['okstatefair_custom_header_sfp']['#markup'] = $block['content'];
        //        $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp');
        //        $vars['page']['footer']['okstatefair_custom_footer_sfp']['#markup'] = $block['content'];
        //        if ($node->type == 'barns') {
        //          $vars['site_type'] .= ' navigation-sidebar-static';
        //        }
        break;
      //     case 'employment':
      //      case 'mission':
      //      case 'sponsorship':
      //      case 'commercials':
      //      case 'photos':
      //      case 'blogpost':
      //        $vars['site_type'] = 'page-type-blog page-employment';
      //        if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
      //          $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
      //        }
      //        if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
      //          $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
      //        }
      //        $block = module_invoke('okstatefair_custom', 'block_view', 'header_2logo');
      //        $vars['page']['header']['okstatefair_custom_header_2logo']['#markup'] = $block['content'];
      //        $block = module_invoke('okstatefair_custom', 'block_view', 'footer_2logo');
      //        $vars['page']['footer']['okstatefair_custom_footer_2logo']['#markup'] = $block['content'];
      //        if ($node->type == 'sponsorship') {
      //          $vars['site_type'] = 'page-type-blog page-type-sponsorship';
      //        }
      //        if ($node->type == 'commercials') {
      //          $vars['site_type'] = 'page page-type-blog';
      //        }
      //        if ($node->type == 'blogpost') {
      //          $vars['page']['header'] = theme('header_2logo_content', array('title' => 'Blog'));
      //          $vars['site_type'] = 'page page-type-blog';
      //          $vars['theme_hook_suggestions'][] = 'page__press';
      //        }
      //        if ($node->type == 'photos') {
      //          $vars['site_type'] = ' page-type-blog page-type-photos';
      //        }
      //        break;
      //      case 'sf_space_sales':
      //      case 'hours_admissions':
      //      case 'volunteer':
      //      case 'bandday':
      //      case 'connection':
      //      case 'arm_wrestling':
      //      case 'wine_competition':
      //      case 'equine':
      //      case 'agtropolis':
      //      case 'barnyard':
      //      case 'exhibits':
      //      case 'cfe':
      //      case 'pageants':
      //      case 'arts':
      //      case 'dr_pepper':
      //      case 'shows':
      //      case 'misc':
      //      case 'parking':
      //      case 'artex':
      //      case 'academy':
      //      case 'opening':
      //      case 'discount':
      //        $vars['site_type'] = 'page-type-1 page-type-v';
      //        if ($node->type == 'discount')
      //          $vars['site_type'] .= ' page page-type-7 ';
      //        $agenda_block = module_invoke('okstatefair_calendar', 'block_view', 'my_agenda');
      //        $vars['page']['header']['okstatefair_calendar_agenda']['#markup'] = $agenda_block['content'];
      //        break;
      //      case 'map':
      //        if ($node->nid != SFP_MAP_NID) {
      //          $vars['site_type'] = 'page-type-1 ';
      //          $agenda_block = module_invoke('okstatefair_calendar', 'block_view', 'my_agenda');
      //          $vars['page']['header']['okstatefair_calendar_agenda']['#markup'] = $agenda_block['content'];
      //        }
      //        else {
      //          if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
      //            $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
      //          }
      //          if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
      //            $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
      //          }
      //          $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp');
      //          $vars['page']['header']['okstatefair_custom_header_sfp']['#markup'] = $block['content'];
      //          $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp');
      //          $vars['page']['footer']['okstatefair_custom_footer_sfp']['#markup'] = $block['content'];
      //          $vars['site_type'] = 'page-type-6 ';
      //        }
      //        $vars['site_type'] .= ' page-type-map';
      //        break;
      //      case 'faq':
      //        $vars['site_type'] = 'page-type-1 page-type-v page-type-7';
      //        $agenda_block = module_invoke('okstatefair_calendar', 'block_view', 'my_agenda');
      //        $vars['page']['header']['okstatefair_calendar_agenda']['#markup'] = $agenda_block['content'];
      //        break;
      //
      default:
        $vars['site_type'] = 'page-type-4';
        break;
    }
  }
  else {

    //    //not node pages
    //    if (in_array('page__state_fair_calendar', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-1';
    //      if (array_key_exists('okstatefair_custom_header_sfp', $vars['page']['header'])) {
    //        $vars['page']['header']['okstatefair_custom_header_sfp']['#access'] = FALSE;
    //      }
    //      if (array_key_exists('okstatefair_custom_footer_sfp', $vars['page']['footer'])) {
    //        $vars['page']['footer']['okstatefair_custom_footer_sfp']['#access'] = FALSE;
    //      }
    //    }
    //    elseif (in_array('page__site__map', $vars['theme_hook_suggestions']) || in_array('page__press', $vars['theme_hook_suggestions']) || in_array('page__blog', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-sitemap';
    //      if (in_array('page__press', $vars['theme_hook_suggestions']))
    //        $vars['site_type'] = 'page page-type-blog page-type-releases';
    //      if (in_array('page__blog', $vars['theme_hook_suggestions'])) {
    //        $vars['site_type'] = 'page page-type-blog';
    //        $vars['theme_hook_suggestions'][] = 'page__press';
    //      }
    //      if (array_key_exists('okstatefair_custom_footer_sf', $vars['page']['footer'])) {
    //        $vars['page']['footer']['okstatefair_custom_footer_sf']['#access'] = FALSE;
    //      }
    //      if (array_key_exists('okstatefair_custom_header_sf', $vars['page']['header'])) {
    //        $vars['page']['header']['okstatefair_custom_header_sf']['#access'] = FALSE;
    //      }
    //    }
    //    elseif (in_array('page__shop', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-1 page-type-v';
    //    }
    //    elseif (in_array('page__instagram', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-promo page-intagram';
    //    }
    //    elseif (in_array('page__food_finder', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-4 page-type-foodfinder';
    //    }
    if (in_array('page__calendar_sfp_mobile', $vars['theme_hook_suggestions'])) {
      $vars['site_type'] = 'page-sfp';
      $block = module_invoke('okstatefair_custom', 'block_view', 'footer_sfp_mobile_buy_ticket');
      $vars['page']['footer']['okstatefair_custom_footer_sfp_mobile']['#markup'] = $block['content'];
      $vars['page']['footer']['okstatefair_custom_footer_sf_mobile']['#access'] = FALSE;
      $block = module_invoke('okstatefair_custom', 'block_view', 'header_sfp_mobile');
      $vars['page']['header']['okstatefair_custom_header_sfp_mobile']['#markup'] = $block['content'];
      $vars['page']['header']['okstatefair_custom_header_sf_mobile']['#access'] = FALSE;
    }
    //    if (in_array('page__search', $vars['theme_hook_suggestions'])) {
    //      $vars['site_type'] = 'page-type-search';
    //    }
  }
  //
  //  if (!isset($vars['site_type'])) {
  //    $vars['site_type'] = 'page-type-4';
  //  }
}

//
///**
// * Override or insert variables into the page templates.
// *
// * @param $variables
// *   An array of variables to pass to the theme template.
// * @param $hook
// *   The name of the template being rendered ("page" in this case.)
// */
//function okstatefair_preprocess_block(&$vars) {
//  switch ($vars['block']->delta) {
//    case'calendar_this_week-block':
//      if (!empty($_GET['sfp_category'])) {
//        $vars['content'] = '';
//      }
//      break;
//    case'calendar_chosen_month-block':
//    case'calendar_coming_up-block_1':
//      if (!empty($_GET['chosen'])) {
//        $vars['content'] = '';
//      }
//      break;
//    case'calendar_chosen_date-block_1':
//      if (empty($_GET['chosen'])) {
//        $vars['content'] = '';
//      }
//      break;
// }
//}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function okstatefair_mobile_preprocess_node(&$vars) {
  /* Mobile */
  $vars['theme_name'] = drupal_get_path('theme', 'okstatefair_mobile');

  /* ENd  Mobile */
  //
  $chickasaw_nodes = chickasaw_nodes();
  $node = $vars['node'];
  $vars['foodfinder'] = variable_get('foodfinder', '');
  //  if (!$vars['page']) {
  //    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];
  //  }
  $check_back_info = isset($node->field_sf_event_check_back[LANGUAGE_NONE][0]['value']) ?
    $node->field_sf_event_check_back[LANGUAGE_NONE][0]['value'] : 0;
  $hook_additional_check = '';
  if ($check_back_info) {
    $hook_additional_check = '__check';
    $vars['check_back_info'] = TRUE;
  }
  if (in_array($node->nid, $chickasaw_nodes) || in_array($node->nid, private_events()) || _okstate_special_performer($node)) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__chickasaw' . $hook_additional_check;
  }
  if ($node->nid == XTREME_CLAY || $node->nid == XTREME_ELI || $node->nid == XTREME_JN || 
    $node->nid == XTREME_MONTGOMERY_GENTRY || $node->nid == XTREME_ELI_YOUNG_BAND  || $node->nid == XTREME_NEW) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__chickasaw__xtreme';
  }
  if ($node->nid == DISNEP_NID) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__disnep' . $hook_additional_check;
    $vars['back_link'] = '';
    $start = t('Sept.') . ' ';
    $start = okstatefair_calendar_prepare_period($node->nid, $start);
    $vars['content']['start'] = $start;
  }
  if ($node->nid == XTREME_BULLS) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__xtreme' . $hook_additional_check;
  }
  if (($node->nid == OKSTATEFAIR_MOBILE_EMPLOYMENT_NID) && (!isset($_GET['device']) || (isset($_GET['device']) && ($_GET['device'] != 'desktop'))) ) {
    drupal_goto('node/' . OKSTATEFAIR_MOBILE_EMPLOYMENT_NID, array('query' => array('device' => 'desktop')));
  }
  switch ($node->type) {
    case 'homesubpark':
      $sfp_map = node_load(SFP_MAP_NID);
      $vars['sfp_map_link'] = file_create_url($sfp_map->field_map_pdf_download[LANGUAGE_NONE]['0']['uri']);
      break;
    case 'food':
      if (in_array('node__view__food_finder__page', $vars['theme_hook_suggestions'])) {
        if (isset($_GET['field_vendors_category_tid'])) {
          $vars['field_vendors_category_tid'] = $_GET['field_vendors_category_tid'];
        } else {
          $vars['field_vendors_category_tid'] = '';
        }
      } else {
        if (isset($_GET['field_vendors_category_tid'])) {
          $vars['url'] = 'field_vendors_category_tid';
          $vars['tid'] = $_GET['field_vendors_category_tid'];
          if (!empty($vars['url']) && !empty($vars['tid']))
            $vars['url_for_share'] = urlencode(url('food-finder', array('absolute' => TRUE, 'query' => array($vars['url'] => $vars['tid']))));
          else
            $vars['url_for_share'] = '';

          $step = 1;
          $all_full_terms = array();
          $current_terms = $_GET['field_vendors_category_tid'];
          $step_terms = array();
          foreach ($node->field_vendors[$node->language] as $value) {
            $terms = field_collection_item_load($value['value']);
            foreach ($terms->field_vendors_category[$node->language] as $terms_value) {
              $step_terms[$step][] = $terms_value['tid'];
            }
            $step++;
          }
          $location = array();
          $description = array();
          foreach ($step_terms as $key => $value) {
            if (in_array($current_terms, $value)) {
              $location[$key] = chr(64 + $key);
            }
            foreach ($value as $terms_value) {
              if (!array_key_exists($terms_value, $description)) {
                if ($current_terms == $terms_value) {
                  $description[$terms_value] = '<span class="selected">' . taxonomy_term_load($terms_value)->name . '</span>';
                } else {
                  $description[$terms_value] = taxonomy_term_load($terms_value)->name;
                }
              }
            }

          }
          $vars['description'] = implode(", ", $description);
          if ($step > 2) {
            $vars['location_str'] = implode(",", $location);
//            if (count($location) > 1) {
              $vars['location_description'] = t('Note: All menu items may not be at all locations.');
//            }
          }
        } else {

        }
      }

      break;
    case 'parking':
      $sfp_map = node_load(SF_MAP_NID);
      $vars['sfp_map_link'] = file_create_url($sfp_map->field_map_pdf_download[LANGUAGE_NONE]['0']['uri']);
      //$vars['sfp_map_link'] = drupal_get_path('theme', 'okstatefair_mobile') . '/images/state_fair_map.pdf';
      break;
    case 'menu_subpage':
      if ($node->nid == 3793) {
//        $vars['block1'] = views_embed_view('xtreme_bulls_tour_mobile', 'block_xtreme');
        $vars['block1'] = views_embed_view('xtreme_bulls_tour_mobile', 'block_chickasaw');
        $vars['block3'] = views_embed_view('xtreme_bulls_tour_mobile', 'block_xtreme');
      } else if ($node->nid == 16852) { //Xtreme Bulls Tour & Concerts
        //$vars['block1'] = views_embed_view('xtreme_bulls_tour_mobile', 'block_xtreme');
      }
      else {
        $allmenu = menu_tree_all_data("menu-mobile-sf");
        $active = menu_get_active_title();
        $active_menu = menu_get_active_trail();
        if (count($active_menu) != 1) {
          foreach ($active_menu as $key => $value) {
            if ($key != 0) {
              foreach ($allmenu as $key2 => $value2) {
                $arrkeyname = explode(' ', $key2);
                if (in_array($value['mlid'], $arrkeyname)) {
                  $nextmenu = $allmenu[$key2]['below'];
                  break;
                }
              }
              if (!empty($nextmenu))
                ($allmenu = $nextmenu);
            }
          }
        }
        $lower_menu = array();
        foreach ($allmenu as $key => $value) {
          if ($value['link']['hidden'] != 1) {
          $full_title = explode(' -- ', $value['link']['link_title']);
          if (count($full_title) >= 2) {
            $main_title = $full_title['0'];
          }
          else           $main_title = $value['link']['link_title'];
          $lower_menu[$key] = array('href' => $value['link']['link_path'], 'title' => $main_title,);
        }
        }
        $vars['sub_menu'] = $lower_menu;
      }

      $path = drupal_get_path('theme', 'okstatefair') . '/images/coming_soon.jpg';
      $check_back_image = array(
        'path' => $path,
        'alt' => t('Comming Soon'),
      );
//      $vars['check_back_image'] = theme('image', $check_back_image);
      break;
    case 'wifi_ad':
      try {
        $node = ($vars['node']->nid == OKSTATEFAIR_MOBILE_SF_WIFI_NID) ? node_load(STATE_FAIR_NID): node_load(STATE_FAIR_PARK_NID);
        $node_wrapper = entity_metadata_wrapper('node', $node);
        $slides = array();
        foreach ($node_wrapper->field_homesub_slides_mobile->value() as $key => $value) {
          $img = theme('image', array(
            'path' => $value['uri'],
            'width' => $value['width'],
            'height' => $value['height'],
          ));
          if (!empty($value['title'])) {
            $slides['items'][] = l($img, $value['title'], array('html' => TRUE));
          }
          else {
            $slides['items'][] = $img;
          }
        }
        if (isset($slides['items']) && !empty($slides['items'])) {
          $slides['attributes']['class'][] = 'slides';
          $slider = theme('item_list', $slides);
          $vars['homesub_slides'] = $slider;
        }
      }
      catch (EntityMetadataWrapperException $exc) {
        watchdog(
          'template',
          'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>',
          NULL, WATCHDOG_ERROR
        );
      }
      break;
    //    case 'home':
    //      $block = block_load('okstatefair_custom', 'header_sf');
    //      $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
    //      $vars['header_red'] = render($render_array);
    //      $block = block_load('okstatefair_custom', 'header_sfp');
    //      $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
    //      $vars['header_blue'] = render($render_array);
    //      $block = block_load('okstatefair_custom', 'footer_sf');
    //      $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
    //      $vars['footer_red'] = render($render_array);
    //      $block = block_load('okstatefair_custom', 'footer_sfp');
    //      $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
    //      $vars['footer_blue'] = render($render_array);
    //      $state_fair = node_view(node_load(STATE_FAIR_NID));
    //      $vars['state_fair_page'] = render($state_fair);
    //      $state_fair_park = node_view(node_load(STATE_FAIR_PARK_NID));
    //      $vars['state_fair_park_page'] = render($state_fair_park);
    //      $agenda_block = module_invoke('okstatefair_calendar', 'block_view', 'my_agenda');
    //      $vars['calendar_agenda']['#markup'] = $agenda_block['content'];
    //      break;
    case 'state_fair_event':
      if (!empty($node->field_sf_event_description)) {
        $text = strip_tags($node->field_sf_event_description[LANGUAGE_NONE][0]['value']) . '%0A';
      }
      else {
        $text = '';
      }
      $url_for_share = urlencode(url('node/' . $node->nid, array('absolute' => TRUE)));
      $vars['twitter'] = l(t('Twitter'), 'http://twitter.com/share?url=' . $url_for_share . '&text=' . $node->title, array('external' => TRUE));
      $vars['fb'] = l(t('FB'), 'https://www.facebook.com/sharer.php?u=' . $url_for_share . '&t=' . $node->title, array('external' => TRUE));
      $vars['mail'] = l(t('mail'), 'mailto:?subject=' . $node->title . '&body=' . $text . $url_for_share, array('external' => TRUE));
          if ($node->nid == XTREME_BULLS) {
            $vars['back_link'] = '';
            $start = t('Sept.') . ' ';
            $start = okstatefair_calendar_prepare_period($vars['node']->nid, $start, FALSE);
            $vars['content']['start'] = $start;
          }
    //      elseif (!array_key_exists('start', $vars['content'])) {
    //        $vars['content']['start'] = '';
    //      }
    //      if (in_array($node->nid, $chickasaw_nodes) || in_array($node->nid, private_events()) || $node->nid == DISNEP_NID || $node->nid == XTREME_BULLS) {
    //        if (isset($vars['content']['field_sf_event_dates'])) {
    //          foreach ($vars['content']['field_sf_event_dates']['#items'] as $delta => $item) {
    //            if (isset($vars['content']['field_sf_event_dates'][$delta]['entity']['field_collection_item'][$item['value']]['field_sf_event_dates_date'])) {
    //              $date_array = $vars['content']['field_sf_event_dates'][$delta]['entity']['field_collection_item'][$item['value']]['field_sf_event_dates_date'];
    //              $timestamp = $date_array['#items'][0]['value'];
    //              $timezone = new DateTimeZone('UTC');
    //              $date_1 = new DateTime($timestamp, $timezone);
    //              $offset = $timezone->getOffset($date_1);
    //              $timestamp_start_date = $date_1->format('U') + $offset;
    //              $date1 = date('l, F d, g:ia', $timestamp_start_date);
    //              $dates[] = $date1;
    //            }
    //          }
    //        }
    //        $vars['dates'] = $dates ? $dates : '';
    //        $vars['print'] = l(t('print'), '', array('external' => TRUE, 'attributes' => array('class' => array('btn-print-small'))));
    //      }
    //      else {
    //        $vars['print'] = '';
    //      }
    //      $vars['add_cl'] = '';
    //      switch ($node->nid) {
    //        case FFF:
    //          $vars['add_cl'] = ' not-image';
    //          break;
    //        case XTREME_CLAY:
    //        case XTREME_ELI:
    //          $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__chickasaw__xtreme';
    //          break;
    //      }
    //      break;
    //    case 'barnyard':
    //      $vars['add_cl'] = '';
    //      switch ($node->nid):
    //        case BANDSHEL:
    //          $vars['add_cl'] = 'with-image image-right';
    //          break;
    //      endswitch;
    //      break;
    //    case 'food':
    //      $vars['url'] = '';
    //      $vars['tid'] = '';
    //      if (isset($_GET['field_bacon_tid'])) {
    //        $vars['url'] = 'field_bacon_tid';
    //        $vars['tid'] = $_GET['field_bacon_tid'];
    //      }
    //      if (isset($_GET['field_on_a_stick_tid'])) {
    //        $vars['url'] = 'field_on_a_stick_tid';
    //        $vars['tid'] = $_GET['field_on_a_stick_tid'];
    //      }
    //      if (isset($_GET['field_deep_fried_tid'])) {
    //        $vars['url'] = 'field_deep_fried_tid';
    //        $vars['tid'] = $_GET['field_deep_fried_tid'];
    //      }
    //      if (isset($_GET['field_other_tid'])) {
    //        $vars['url'] = 'field_other_tid';
    //        $vars['tid'] = $_GET['field_other_tid'];
    //      }
    //      if (!empty($vars['url']) && !empty($vars['tid']))
    //        $url_for_share = urlencode(url('food-finder', array('absolute' => TRUE, 'query' => array($vars['url'] => $vars['tid']))));
    //      else
    //        $url_for_share = '';
    //      $vars['url_for_share'] = $url_for_share;
    //      break;
    //    case 'cfe':
    //      $vars['add_cl'] = 'with-image image-right';
    //      break;
    //    case 'video':
    //      $vars['theme_hook_suggestions'][] = 'node__arena';
    //      break;
    //    case 'photos':
    //      $vars['theme_hook_suggestions'][] = 'node__commercials';
    //      break;
    //    case 'blogpost':
    //      $url_for_share = urlencode(url('node/' . $node->nid, array('absolute' => TRUE)));
    //      $vars['twitter'] = l(t('Twitter'), 'http://twitter.com/share?url=' . $url_for_share . '&text=' . $node->title, array('external' => TRUE));
    //      $vars['fb'] = l(t('FB'), 'https://www.facebook.com/sharer.php?u=' . $url_for_share . '&t=' . $node->title . '?v=1', array('external' => TRUE));
    //      $vars['print'] = l(t('print'), '', array('external' => TRUE, 'attributes' => array('class' => array('link-print-inline'))));
    //
    //      break;
    //    case 'contact':
    //      $block = module_invoke('webform', 'block_view', 'webform-client-form-' . WEBFORM__NID);
    //      drupal_add_js('Drupal.behaviors.form_validate', 'inline');
    //      $vars['formochka'] = $block['content'];
    //      $vars['formochka_title'] = $block['subject'];
    //      break;
    case 'state_fair_park_event':
      if (!empty($node->field_sfp_event_description)) {
        $text = $node->field_sfp_event_description[LANGUAGE_NONE][0]['value'] . '%0A';
      }
      else {
        $text = '';
      }
      $url_for_share = urlencode(url('node/' . $node->nid, array('absolute' => TRUE)));
      $vars['twitter'] = l(t('Twitter'), 'http://twitter.com/share?url=' . $url_for_share . '&text=' . $node->title, array('external' => TRUE));
      $vars['fb'] = l(t('FB'), 'https://www.facebook.com/sharer.php?u=' . $url_for_share . '&t=' . $node->title . '?v=1', array('external' => TRUE));
      $vars['mail'] = l(t('mail'), 'mailto:?subject=' . $node->title . '&body=' . $text . $url_for_share, array('external' => TRUE));
      $vars['print'] = l(t('print'), '', array('external' => TRUE, 'attributes' => array('class' => array('btn-print-small'))));

      if (!empty($node->field_sfp_event_dates[LANGUAGE_NONE])) {
        $dates_enmntity_id = array();
        foreach ($node->field_sfp_event_dates[LANGUAGE_NONE] as $val) {
          $dates_enmntity_id[] = $val['value'];
        }
        $entity = entity_load('field_collection_item', $dates_enmntity_id);
        $period = array();
        if (!empty($entity) && is_array($entity)) {
          foreach ($entity as $key => $val) {
            $value_1 = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['value'];
            $value_2 = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['value2'];
            $timezone_db_default = 'UTC';
            $timezone_default = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['value2'];
            if (!empty($value_1)) {
              if (!empty($val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone_db'])) {
                $timezone_db_default = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone_db'];
              }
              if (!empty($val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone'])) {
                $timezone_default = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone'];
              }
              $date = new DateObject($value_1, $timezone_db_default, 'Y-m-d H:i:s');
              $day = format_date($date->format('U'), 'custom', 'j', $timezone_default); //format_date($value_1, 'custom', 'j', $timezone = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone']);// date('j', $value_1);
              $month = format_date($date->format('U'), 'custom', 'n', $timezone_default);
              $year = format_date($date->format('U'), 'custom', 'Y', $timezone_default);
              $period[$year][$month][$day] = TRUE;
            }
            if (!empty($value_2)) {
              if (!empty($val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone_db'])) {
                $timezone_db = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone_db'];
              }
              if (!empty($val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone'])) {
                $timezone = $val->field_sfp_event_dates_date[LANGUAGE_NONE][0]['timezone'];
              }
              $date2 = new DateObject($value_2, $timezone_db_default, 'Y-m-d H:i:s');
              $day2 = format_date($date2->format('U'), 'custom', 'j', $timezone_default);
              $month2 = format_date($date2->format('U'), 'custom', 'n', $timezone_default);
              $year2 = format_date($date2->format('U'), 'custom', 'Y', $timezone_default);
              $period[$year2][$month2][$day2] = TRUE;
            }
          }
        }
        $vars['event_park_warning'] = variable_get('event_park_warning', '');
        //sort asc dates
        if (!empty($period)) {
          foreach ($period as $year => $monthes) {
            if (!empty($monthes)) {
              foreach ($monthes as $month => $dates) {
                ksort($period[$year][$month]);
              }
            }
            ksort($period[$year]);
          }
        }
        $vars['date_interval'] = '';
        $min_date = NULL;
        $max_date = NULL;
        //do not touch it =)
        if (!empty($period)) {
          foreach ($period as $year => $monthes) {
            if (!empty($monthes)) {
              $first_month_in_year = TRUE;
              foreach ($monthes as $month => $dates) {
                if (!empty($dates)) {
                  if (!empty($vars['date_interval']) && !$first_month_in_year) {
                    //there is a som month before, add space
                    $vars['date_interval'] .= ', ';
                  }
                  $first_month_in_year = FALSE;
                  $dates_length = count($dates);
                  $k = 1;
                  $interval = '';
                  foreach ($dates as $day => $val) {
                    if (empty($min_date)) {
                      //first time in this month
                      $min_date = $day;
                      $vars['date_interval'] .= custom_month(date('M', strtotime($year . '-' . $month . '-' . $day))) . ' ';
                      $interval = $min_date;
                      if ($k >= $dates_length) {
                        //that's first and last one day in month, finalize our interval.
                        $vars['date_interval'] .= $interval;
                      }
                    }
                    else {
                      if ((($min_date + 1) == $day) || (($max_date + 1) == $day)) {

                        $max_date = $day;
                        $interval = $min_date . '-' . $max_date;
                        //than only one day difference between dates
                        //add '-' dash sepaator
                        if ($k < $dates_length) {
                          //than its not the end, we need to try and find more intervals
                        }
                        else {
                          //that's last one day in month we need finalize our interval. because it was one interval through all month
                          $vars['date_interval'] .= $interval;
                        }
                      }
                      else {
                        //than more than one day difference between dates
                        //add ',' comma separator
                        if ($k < $dates_length) {
                          //than its not the end, set previous interval and continue find more intervals
                          $vars['date_interval'] .= $interval . ' and ';
                        }
                        else {
                          //that's last one day in month fe need finalize our interval
                          $vars['date_interval'] .= $interval . ' and ' . $day;
                        }
                        $min_date = $day;
                      }
                    }
                    $k++;
                  }
                }
                $min_date = NULL;
                $max_date = NULL;
              }
              $vars['date_interval'] .= ', ' . $year . '</br>';
              $first_month_in_year = FALSE;
            }
          }
        }
      }
      break;
  }
}

/**
 * Theme preprocess function for theme_field() and field.tpl.php.
 *
 * @see theme_field()
 * @see field.tpl.php
 */
function okstatefair_mobile_preprocess_field(&$vars, $hook) {
  switch ($vars['element']['#field_name']) {
    case 'field_homesubpark_blocks' :
    case 'field_homesub_blocks' :
    case 'field_event_subpage_audio' :
      //case 'field_sf_event_dates' :
      //case 'field_sfp_event_dates' :
    case 'field_feed_bedding_content' :
    case 'field_bandday_content' :
    case 'field_competition_logos' :
    case 'field_competition_content' :
    case 'field_barnyard_content_wi' :
    case 'field_cfe_columns' :
    case 'field_right_images_even' :
    case 'field_right_images_even_location' :
    case 'field_pageants_persons' :
    case 'field_expo_content' :
    case 'field_video_striped' :
    case 'field_cu_gallery' :
    case 'field_faq_content_bottom' :
    case 'field_faq_content_top' :
    case 'field_coporate_sponsors' :
    case 'field_sponsorship' :
    case 'field_sponsorship_sponsors' :
    case 'field_content_locations' :
    case 'field_shows_content' :
      $field_obj = $vars['items'];
      foreach ($field_obj as $key => $value) {
        $vars['items'][$key]['links']['#access'] = FALSE;
      }
      break;
    case 'field_sf_event_dates' :
      $field_obj = $vars['items'];
      foreach ($field_obj as $key => $value) {
        unset($vars['items'][$key]['#theme_wrappers']);
        $vars['items'][$key]['links']['#access'] = FALSE;
      }
      usort($vars['items'], "date_sf_sorting");
      break;
    case 'field_sfp_event_dates' :
      $field_obj = $vars['items'];
      foreach ($field_obj as $key => $value) {
        $vars['items'][$key]['links']['#access'] = FALSE;
      }
      usort($vars['items'], "date_sfp_sorting");
      break;
    case 'field_sf_event_dates_date' :
      $field_obj = $vars['items'];
      $start_date = $vars['element']['#items'][0]['value'] ? $vars['element']['#items'][0]['value'] : '';
      $end_date = $vars['element']['#items'][0]['value2'] ? $vars['element']['#items'][0]['value2'] : '';
      $timezone = new DateTimeZone(date_default_timezone_get());
      $curday_date = new DateTime($start_date, $timezone);
      $offset = $timezone->getOffset($curday_date);
      $curday_date = $curday_date->format('U') + $offset;
      $month = custom_month(date('M', $curday_date));
      $vars['date1'] = $month . date('d', $curday_date);
      $mins = date('i', $curday_date);
      if ($mins == '00') {
        $vars['date2'] = date('ga', $curday_date);
      }
      else {
        $vars['date2'] = date('g:ia', $curday_date);
      }
      if (!empty($vars['element']['#object']->field_sf_event_starred[LANGUAGE_NONE][0]['value'])) {
        $vars['date2'] .= '*';
      }
      _okstatefair_replace_am_to_pm_one_hour_after_midnight($vars['date2'], $curday_date);
      if (!empty($end_date) && $end_date != $start_date) {
        $curday_date = new DateTime($end_date, $timezone);
        $offset = $timezone->getOffset($curday_date);
        $curday_date = $curday_date->format('U') + $offset;
        $mins = date('i', $curday_date);
        if ($mins == '00') {
          $vars['enddate'] = ' - ' . date('ga', $curday_date);
        }
        else {
          $vars['enddate'] = ' - ' . date('g:ia', $curday_date);
        }
        _okstatefair_replace_am_to_pm_one_hour_after_midnight($vars['enddate'], $curday_date);
      }
      else {
        $vars['enddate'] = '';
      }

      foreach ($field_obj as $key => $value) {
        $vars['items'][$key]['links']['#access'] = FALSE;
      }
      break;
    case 'field_sfp_event_dates_date' :

      //add custom display for fill event page
      $field_obj = $vars['items'];
      $start_date = $vars['element']['#items'][0]['value'] ? $vars['element']['#items'][0]['value'] : '';
      $end_date = $vars['element']['#items'][0]['value2'] ? $vars['element']['#items'][0]['value2'] : '';

      $timezone_default = new DateTimeZone(date_default_timezone_get());
      $timezone = new DateTimeZone('UTC');

      $date_1 = new DateTime($start_date, $timezone);
      $date_2 = new DateTime($end_date, $timezone);
      $offset = $timezone->getOffset($date_1);
      $timestamp_start_date = $date_1->format('U') + $offset;
      $offset = $timezone->getOffset($date_2);
      $timestamp_end_date = $date_2->format('U') + $offset;
      $vars['date0'] = date('l', $timestamp_start_date);
      //add space before short dates, this is for align
      $vars['date1'] = date('F d, Y', $timestamp_start_date);

      if (!empty($end_date) && $timestamp_start_date != $timestamp_end_date) {
        $vars['date2'] = date('g:ia', $timestamp_start_date) . ' - ' . date('g:ia', $timestamp_end_date) ;
        //_okstatefair_replace_am_to_pm_one_hour_after_midnight($vars['date2'], $timestamp_end_date);
      }
      else {
        $vars['date2'] = date('g:ia', $timestamp_start_date);
      }
      if (!empty($end_date) && date('Y-m-d', $timestamp_start_date) != date('Y-m-d', $timestamp_end_date)) {
        $month = custom_month(date('M', $timestamp_end_date));
        $vars['date0'] .= '-' . $month . date('d', $timestamp_end_date);
      }
      foreach ($field_obj as $key => $value) {
        $vars['items'][$key]['links']['#access'] = FALSE;
      }
      break;
    case 'field_homesub_foodfinder' :
      $vars['foodfinder'] = variable_get('foodfinder', '');
      break;
    default:
      break;
  }
}

/**
 * theme_item_list()
 */
function okstatefair_mobile_item_list($variables) {
  $attributes = array();
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];
  $output = '';
  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.

  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }

  return $output;
}

/**
 * theme_menu_tree()
 */
function okstatefair_menu_link__menu_block__1($vars) {
  $element = $vars['element'];
  $cl = '';
  $cl2 = '';
  $suffix = '';
  $sub_menu = '';
  if (in_array('active-trail', $element['#attributes']['class'])) {
    $cl .= ' active';
  }
  if ($element['#original_link']['depth'] == 2) {

    if ($element['#below']) {
      $sub_menu = drupal_render($element['#below']);
      $element['#localized_options']['attributes']['class'][] = 'btn';
      $cl2 = ' dropdown ';
      $suffix = '<span class="icon-dropdown"></span>';
    }
  }
  if ($element['#original_link']['depth'] == 3) {
    if ($element['#below']) {
      $element['#localized_options']['attributes']['class'][] = 'btn';
      $sub_menu = drupal_render($element['#below']);
      $cl2 = ' dropdown ';
      $suffix = '<span class="icon-dropdown"></span>';
    }
  }

  $element['#localized_options']['html'] = TRUE;
  $output = l($element['#title'] . $suffix, $element['#href'], $element['#localized_options']);
  return '<li class="' . $cl . $cl2 . '">' . $output . $sub_menu . "</li>\n";
}

/**
 * theme_menu_tree()
 */
function okstatefair_menu_tree__menu_block__1($vars) {
  // Change id of menu ul
  return '<ul>' . $vars['tree'] . '</ul>';
}

/**
 * template_preprocess_views_view()
 */
function okstatefair_mobile_preprocess_views_view(&$vars) {
  if ($vars['view']->name == 'food_finder') {
    $vars['view']->food_custom_block = okstatefair_mobile_food_custom_block();
    if (isset ($_GET['field_vendors_category_tid'])) {
      $term = taxonomy_term_load($_GET['field_vendors_category_tid']);
      $vars['view']->food_custom_title = '<i>' . t('Showing Vendor(s) for') . '</i>' . $term->name;
    } else {
      //$vars['view']->food_custom_title = t('Food Finder');
    }

    $vars['no_food_finder_access'] = !user_access('okstate custom view food finder');
    $path = drupal_get_path('theme', 'okstatefair') . '/images/coming_soon.jpg';
    $check_back_image = array(
      'path' => $path,
      'alt' => t('Comming Soon'),
    );
    $vars['check_back_image'] = theme('image', $check_back_image);
  }
  if ($vars['view']->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR) {

    if (isset($vars['view']->exposed_raw_input['sfp_category']) && $vars['view']->exposed_raw_input['sfp_category'] != 'All') {
      $term = taxonomy_term_load($vars['view']->exposed_raw_input['sfp_category']);
      $vars['view']->filter_title = $term->name;
    }
    else {
      $vars['view']->filter_title = $vars['view']->exposed_raw_input['sfp_category'];
    }

    //get all filter query fror views
    $query_args = $vars['view']->exposed_input;
    //chage date for link
    if (array_key_exists('month', $query_args)) {
      $next_year_query_args = $query_args;
      $prev_year_query_args = $query_args;
      $date = explode('-', $query_args['month']);
    }
    else {
      $date = explode('-', $vars['view']->args[0]);
    }
    unset($query_args['chosen']);
    $vars['view']->prev_year = l(t('Previous Year'), OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_MOBILE_PAGE_PATH . '/' . ($date[0] - 1) . '-' . $date[1], array('absolute' => TRUE, 'query' => $query_args, 'attributes' => array('rel' => 'nofollow', 'class' => array('left-nav-item'))));
    $vars['view']->next_year = l(t('Next Year'), OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_MOBILE_PAGE_PATH . '/' . ($date[0] + 1) . '-' . $date[1], array('absolute' => TRUE, 'query' => $query_args, 'attributes' => array('rel' => 'nofollow', 'class' => array('right-nav-item'))));
    $vars['view']->display_year = $date[0];
    $vars['view']->display_month = $date[1];
    /*if ($vars['view']->use_ajax) {
      drupal_add_js(path_to_theme() . '/js/ajax_view.js', 'file');
    }*/
  }
  if ($vars['view']->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_CALENDAR_CHOSEN_MONTH) {
    if (!empty($vars['view']->args[0])) {
      $timestamp = DateTime::createFromFormat('!Y-m', $vars['view']->args[0])->getTimestamp();
      $month_name = format_date($timestamp, 'custom', 'F');
      $vars['view']->build_info['title'] .= ' ' . $month_name;
    }
  }
  if ($vars['view']->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_CALENDAR_CHOSEN_DATE) {
    if (!empty($vars['view']->args[0])) {
      $timestamp = DateTime::createFromFormat('!Y-m-d', $vars['view']->args[0])->getTimestamp();
      $date_text = format_date($timestamp, 'custom', 'F jS');
      $vars['view']->build_info['title'] .= ' ' . $date_text;
    }
  }
}

/**
 * template_preprocess_views_view_table()
 */
function okstatefair_preprocess_views_view_table(&$vars) {

  switch ($vars['view']->name) {
    case OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_CALENDAR_CHOSEN_MONTH:
    case OKSTATEFAIR_VIEWS_CALENDAR_COMING_UP:
    case OKSTATEFAIR_VIEWS_CALENDAR_HTIS_WEEK:
      okstatefair_calendar_group_nearest_events($vars, 'field_sfp_event_dates_date');
    case OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_CALENDAR:
      $dest = drupal_get_destination();
      if (!empty($vars['rows'])) {
        foreach ($vars['rows'] as $key => $val) {
          $vars['rows'][$key]['title'] = l($vars['result'][$key]->node_title, 'node/' . $vars['result'][$key]->nid, array('query' => $dest));
        }
      }
      break;
    case OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_CALENDAR_CHOSEN_DATE:
      $dest = drupal_get_destination();
      if (!empty($vars['rows'])) {
        foreach ($vars['rows'] as $key => $val) {
          $vars['rows'][$key]['title'] = l($vars['result'][$key]->node_title, 'node/' . $vars['result'][$key]->nid, array('query' => $dest));
          $daytimestamp = strtotime($vars['view']->result[$key]->field_field_sfp_event_dates_date['0']['raw']['value']);
          $month = custom_month(date('M', $daytimestamp));
          $vars['rows'][$key]['field_sfp_event_dates_date'] = $month . date('d', $daytimestamp);
        }
      }
      break;
  }
}

/**
 * template_preprocess_views_view_list()
 */
function okstatefair_mobile_preprocess_views_view_list(&$vars) {
  switch ($vars['view']->name) {
    case OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_MOBILE_CALENDAR:
      $start_date = $vars['view']->result[$vars['view']->row_index]->field_field_sf_event_dates_date['0']['raw']['value'];
      $tz = new DateTimeZone($vars['view']->result[$vars['view']->row_index]->field_field_sf_event_dates_date['0']['raw']['timezone']);
      $offset = $tz->getOffset(new DateTime($start_date));
      $start_stamp = strtotime($start_date) + $offset;
      if(date('Y', $start_stamp) == date('Y') && date('m', $start_stamp) == date('m') && date('d', $start_stamp) == date('d')){
        $vars['title_id'] = 'time-'.date('H-i', $start_stamp);
      }
      break;
  }
}
/**
 * template_preprocess_views_view_unformatted()
 */
function okstatefair_mobile_preprocess_views_view_unformatted(&$vars) {

  if ($vars['view']->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR) {
    //if (count($vars['rows']) > 1) {
      reset($vars['rows']);
      $first_key = key($vars['rows']);
      end($vars['rows']);
      $end_key = key($vars['rows']);
      $vars['has_target'] = FALSE;
      $timezone = new DateTimeZone('UTC');
      foreach ($vars['rows'] as $resilt_id => $var) {
        //create delimeter for event between dates.
        //remove unnessesary data between start and end dates.
        //change edn date.
        $date = strtotime($vars['view']->result[$resilt_id]->field_field_sfp_event_dates_date[0]['raw']['value']);
        $date_2 = new DateTime($vars['view']->result[$resilt_id]->field_field_sfp_event_dates_date[0]['raw']['value'], $timezone);
        $offset = $timezone->getOffset($date_2);
        $date = $date_2->format('U') + $offset;
        if ($first_key == $resilt_id) {
          $vars['rows'][$resilt_id] = custom_month(date('M', $date)) . ' ' . date('d', $date) ;
        }
        else {
          if ($end_key == $resilt_id) {
            $vars['rows'][$resilt_id] = format_date($date, 'calendar_mobile_end_date', '', $vars['view']->result[$resilt_id]->field_field_sfp_event_dates_date[0]['raw']['timezone']);
          }
          else {
            unset($vars['rows'][$resilt_id]);
          }
        }
        //add target to scroll
        if (!$vars['has_target'] && (time() <= $date)) {
          $vars['has_target'] = TRUE;
        }
      //}
    }
  }
}

/**
 * template_preprocess_date_views_pager
 */
function okstatefair_preprocess_date_views_pager(&$vars) {
  if ($vars['plugin']->view->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR) {
    //remove title temporary
    $date = explode('-', $vars['plugin']->view->args[0]);
    $vars['selected_year'] = $date[0];
    $vars['selected_month'] = $date[1];
    $query = array();
    if (!empty($_GET['chosen'])) {
      $query['chosen'] = $_GET['chosen'];
    }
    if (!empty($vars['input'])) {
      foreach ($vars['input'] as $key => $val) {
        $query[$key] = $val;
      }
    }
    unset($query['chosen']);
    $vars['select_query'] = $query;
  }
}

/**
 * theme_menu_link()
 */
function okstatefair_menu_link__menu_block__2($vars) {
  $element = $vars['element'];
  $cl = '';
  $cl2 = '';
  $suffix = '';
  $sub_menu = '';
  if (in_array('active-trail', $element['#attributes']['class'])) {
    $cl .= ' active';
  }
  if ($element['#original_link']['depth'] == 2) {

    if ($element['#below']) {
      $sub_menu = drupal_render($element['#below']);
      $element['#localized_options']['attributes']['class'][] = 'btn';
      $cl2 = ' dropdown ';
      $suffix = '<span class="icon-dropdown"></span>';
    }
  }
  if ($element['#original_link']['depth'] == 3) {
    if ($element['#below']) {
      $element['#localized_options']['attributes']['class'][] = 'btn';
      $sub_menu = drupal_render($element['#below']);
      $cl2 = ' dropdown ';
      $suffix = '<span class="icon-dropdown"></span>';
    }
  }

  $element['#localized_options']['html'] = TRUE;
  $output = l($element['#title'] . $suffix, $element['#href'], $element['#localized_options']);
  return '<li class="' . $cl . $cl2 . '">' . $output . $sub_menu . "</li>\n";
}

/**
 * theme_menu_tree()
 */
function okstatefair_menu_tree__menu_block__2($vars) {
  // Change id of menu ul
  return '<ul>' . $vars['tree'] . '</ul>';
}

/**
 * Returns HTML for a date element formatted as a range.
 */
function okstatefair_date_display_range($variables) {
  $date1 = $variables['date1'];
  $date2 = $variables['date2'];
  $timezone = $variables['timezone'];
  $attributes_start = $variables['attributes_start'];
  $attributes_end = $variables['attributes_end'];

  // Wrap the result with the attributes.
  $format = date_format_type_format('calendar_start_date', NULL);
  if ($variables['dates']['format'] == $format) {
    $date2 = format_date(strtotime($variables['dates']['value2']['db']['datetime']), 'calendar_end_date');
    return t('!start-date!end-date', array('!start-date' => '<span class="date-display-start"' . drupal_attributes($attributes_start) . '>' . $date1 . '</span>', '!end-date' => '<span class="date-display-end"' . drupal_attributes($attributes_end) . '>' . $date2 . $timezone . '</span>',));
  }
  else {
    return t('!start-date to !end-date', array('!start-date' => '<span class="date-display-start"' . drupal_attributes($attributes_start) . '>' . $date1 . '</span>', '!end-date' => '<span class="date-display-end"' . drupal_attributes($attributes_end) . '>' . $date2 . $timezone . '</span>',));
  }
}

/**
 * Create the calendar date box.
 */
function okstatefair_preprocess_calendar_datebox(&$vars) {
  $date = $vars['date'];
  $view = $vars['view'];
  $vars['day'] = intval(substr($date, 8, 2));
  $force_view_url = !empty($view->date_info->block) ? TRUE : FALSE;
  $month_path = calendar_granularity_path($view, 'month');
  $year_path = calendar_granularity_path($view, 'year');
  $day_path = calendar_granularity_path($view, 'day');
  if ($vars['view']->name == OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR) {
    if (empty($vars['view']->args[0])) {
      $vars['view']->args[0] = '';
    }
    $query = array('chosen' => $vars['date']);
    if (!empty($vars['view']->exposed_raw_input)) {
      foreach ($vars['view']->exposed_raw_input as $key => $val) {
        $query[$key] = $val;
      }
    }
    $vars['url'] = url(OKSTATEFAIR_VIEWS_CALENDAR_STATE_FAIR_PARK_CALENDAR_PAGE_PATH . '/' . $vars['view']->args[0], array('query' => $query));
  }
  else {
    $vars['url'] = str_replace(array($month_path, $year_path), $day_path, date_pager_url($view, NULL, $date, $force_view_url));
  }
  $vars['link'] = !empty($day_path) ? '<a href="' . $vars['url'] . '">' . $vars['day'] . '</a>' : $vars['day'];
  $vars['granularity'] = $view->date_info->granularity;
  $vars['mini'] = !empty($view->date_info->mini);
  if ($vars['mini']) {
    if (!empty($vars['selected'])) {
      $vars['class'] = 'mini-day-on';
    }
    else {
      $vars['class'] = 'mini-day-off';
    }
  }
  else {
    $vars['class'] = 'day';
  }
}

/**
 * Process variables for search-result.tpl.php.
 *
 * The $variables array contains the following arguments:
 * - $result
 * - $module
 *
 * @see search-result.tpl.php
 */
function okstatefair_preprocess_search_result(&$variables) {
  switch ($variables['result']['node']->type) {
    case 'state_fair_park_event' :
    case 'ticket_office' :
    case 'rvpark' :
    case 'feed_bedding' :
    case 'homesubpark' :
      $variables['search_result_type'] = "search-result_2";
      break;
    default:
      $variables['search_result_type'] = "search-result_1";
      break;
  }
}

/**
 * Process variables for search-results.tpl.php.
 *
 * The $variables array contains the following arguments:
 * - $results: Search results array.
 * - $module: Module the search results came from (module implementing
 *   hook_search_info()).
 *
 * @see search-results.tpl.php
 */
function okstatefair_preprocess_search_results(&$variables) {
  $variables['pager_total_items'] = $GLOBALS['pager_total_items'][0];
  $variables['pager_limits'] = $GLOBALS['pager_limits'][0];
}

/**
 * Sort function by dates for SF event
 */
function date_sf_sorting($a, $b) {
  $date1 = each($a['entity']['field_collection_item']);
  $time1 = strtotime($date1['value']['field_sf_event_dates_date']['#items'][0]['value']);
  $date2 = each($b['entity']['field_collection_item']);
  $time2 = strtotime($date2['value']['field_sf_event_dates_date']['#items'][0]['value']);
  if ($time1 == $time2) {
    return 0;
  }
  return ($time1 < $time2) ? -1 : 1;
}

/**
 * Sort function by dates for SF event
 */
function date_sfp_sorting($a, $b) {
  $date1 = each($a['entity']['field_collection_item']);
  $time1 = strtotime($date1['value']['field_sfp_event_dates_date']['#items'][0]['value']);
  $date2 = each($b['entity']['field_collection_item']);
  $time2 = strtotime($date2['value']['field_sfp_event_dates_date']['#items'][0]['value']);
  if ($time1 == $time2) {
    return 0;
  }
  return ($time1 < $time2) ? -1 : 1;
}

/**
 * weird Cameron ask; change am to pm from 00:00 to 00:59
 */
function _okstatefair_replace_am_to_pm_one_hour_after_midnight(&$date2, $timestamp) {
  //if((int)date('H', $curday_date) < 12){
  //in reality AM
  if ((int)date('H:i:s', $timestamp) == '00:00:00') {
    //actually the most difficult to recognize time
    //in reality this is a 12:01 AM - 12:59 AM
    //not actually 00:01 PM - 00:59 PM
    $date2 = str_replace('am', 'pm', $date2);
  }
  //}else{
  //in reality PM
  //}
}

/**
 * Themes a select drop-down as a collection of links
 *
 * @see theme_select(), http://api.drupal.org/api/function/theme_select/6
 * @param array $vars - An array of arrays, the 'element' item holds the properties of the element.
 *                      Properties used: title, value, options, description, name
 * @return HTML string representing the form element.
 */
function okstatefair_select_as_links($vars) {
  $element = $vars['element'];
  $ul_start = '';
  $ul_fin = '';
  $li_start = '';
  $li_fin = '';
  if ($element['#name'] == 'field_blog_categories_tid') {
    $ul_start = '<ul class="color-point">';
    $ul_fin = '</ul>';
    $li_start = '<li>';
    $li_fin = '</li>';
  }
  $output = '';
  $name = $element['#name'];

  // Collect selected values so we can properly style the links later
  $selected_options = array();
  if (empty($element['#value'])) {
    if (!empty($element['#default_values'])) {
      $selected_options[] = $element['#default_values'];
    }
  }
  else {
    $selected_options[] = $element['#value'];
  }

  // Add to the selected options specified by Views whatever options are in the
  // URL query string, but only for this filter
  $urllist = parse_url(request_uri());
  if (isset($urllist['query'])) {
    $query = array();
    parse_str(urldecode($urllist['query']), $query);
    foreach ($query as $key => $value) {
      if ($key != $name) {
        continue;
      }
      if (is_array($value)) {
        // This filter allows multiple selections, so put each one on the selected_options array
        foreach ($value as $option) {
          $selected_options[] = $option;
        }
      }
      else {
        $selected_options[] = $value;
      }
    }
  }

  // Clean incoming values to prevent XSS attacks
  if (is_array($element['#value'])) {
    foreach ($element['#value'] as $index => $item) {
      unset($element['#value'][$index]);
      $element['#value'][filter_xss($index)] = filter_xss($item);
    }
  }
  else if (is_string($element['#value'])) {
    $element['#value'] = filter_xss($element['#value']);
  }
  $output = $ul_start;
  // Go through each filter option and build the appropriate link or plain text
  foreach ($element['#options'] as $option => $elem) {
    // Check for Taxonomy-based filters
    if (is_object($elem)) {
      $slice = array_slice($elem->option, 0, 1, TRUE);
      list($option, $elem) = each($slice);
    }

    /*
     * Check for optgroups.  Put subelements in the $element_set array and add a group heading.
     * Otherwise, just add the element to the set
     */
    $element_set = array();
    if (is_array($elem)) {
      $element_set = $elem;
    }
    else {
      $element_set[$option] = $elem;
    }

    $links = array();
    $multiple = !empty($element['#multiple']);

    foreach ($element_set as $key => $value) {
      // Custom ID for each link based on the <select>'s original ID
      $id = drupal_html_id($element['#id'] . '-' . $key);
      $elem = array('#id' => $id, '#markup' => '', '#type' => 'bef-link', '#name' => $id,);

      if (array_search($key, $selected_options) === FALSE) {
        $elem['#children'] = $li_start . l($value, okstatefair_bef_replace_query_string_arg($name, $key, $multiple)) . $li_fin;
        ;
        $output .= theme('form_element', array('element' => $elem));
      }
      else {
        $elem['#children'] = $li_start . l($value, okstatefair_bef_replace_query_string_arg($name, $key, $multiple, TRUE)) . $li_fin;
        _form_set_class($elem, array('bef-select-as-links-selected'));
        $output .= str_replace('form-item', 'form-item selected', theme('form_element', array('element' => $elem)));
      }
    }
  }
  $output .= $ul_fin;
  $properties = array('#description' => isset($element['#bef_description']) ? $element['#bef_description'] : '', '#children' => $output,);

  $output = '<div class="bef-select-as-links">';
  $output .= theme('form_element', array('element' => $properties));

  if (!empty($element['#value'])) {
    if (is_array($element['#value'])) {
      foreach ($element['#value'] as $value) {
        $output .= '<input type="hidden" name="' . $name . '[]" value="' . $value . '" />';
      }
    }
    else {
      $output .= '<input type="hidden" name="' . $name . '" value="' . $element['#value'] . '" />';
    }
  }
  $output .= '</div>';

  return $output;
}

/**
 * Replaces/adds a given query string argument to the current URL
 *
 * @param string $key query string key (argument)
 * @param string $value query string value
 * @param bool $multiple TRUE if this key/value pair allows multiple values
 * @param bool $remove TRUE if this key/value should be a link to remove/unset the filter
 */
function okstatefair_bef_replace_query_string_arg($key, $value, $multiple = FALSE, $remove = FALSE) {
  $path = arg();

  // Prevents us from having to check for each index from parse_url that we may use
  $urllist = array('path' => '', 'fragment' => '', 'query' => '');
  $urllist = array_merge($urllist, parse_url(request_uri()));
  $fragment = urldecode($urllist['fragment']);
  $query = array();
  $query[$key] = $value;

  return url(implode('/', $path), array('query' => $query, 'fragment' => $fragment, 'absolute' => TRUE,));
}

/**
 * Implementation of hook_theme()
 */
function okstatefair_mobile_theme() {
  return array('sub_menu' => array('element' => 'menu'),);
}

/**
 *  custom function theme_explore_menu()
 */
function okstatefair_mobile_sub_menu($menu) {
  $output = '';
  foreach ($menu as $key => $value) {
    if (isset($value['title'])) {
      $output .= '<div class="btn-item-wrapper btn-item-full">';
      $output .= l('<span class="text-btn">' . $value['title'] . '</span>', $value['href'], array(
        'html' => TRUE,
        'attributes' => array('class' => array('btn-item'))
      ));
      $output .= "</div>";
    }
  }
  return $output;
}

/**
 * Themes field collection items printed using the field_collection_view formatter.
 */
function okstatefair_mobile_field_collection_view($variables) {
  $element = $variables['element'];
  return $element['#children'];
}

/**
 * theme_date_display_single().
 */
function okstatefair_mobile_date_display_single($variables) {
  $date = $variables['date'];
  $timezone = $variables['timezone'];
  $attributes = $variables['attributes'];

  // Wrap the result with the attributes.
  return $date . $timezone;
}

/*
 * Custom filters for food-finder view
 */
function okstatefair_mobile_food_custom_block (){
  $vocabulary = taxonomy_vocabulary_machine_name_load('Other');
  $vocabulary_tree = taxonomy_get_tree($vocabulary->vid);
  $food_categories = taxonomy_vocabulary_machine_name_load('food_categories');
  $food_categories_tree = taxonomy_get_tree($food_categories->vid);
  $food_categories_tids = array();
  $bacon = '';
  $deep_fried = '';
  $on_a_stick = '';
  $gtof = '';
  $all = '';
  foreach ($food_categories_tree as $key => $value) {
    $food_categories_tids[$value->name] = $value->tid;
  }
  foreach ($vocabulary_tree as $key => $value) {
    $term = taxonomy_term_load($value->tid);
    $all .= '  <li>
      <a href="food-finder?field_vendors_category_tid=' . $term->tid . '&all=1"><span class="nav-text-full">' . $term->name . '</span></a>
  </li>
';
    if (!empty($term->field_food_categories)) {
      foreach ($term->field_food_categories[LANGUAGE_NONE] as $value_food) {

        if ($food_categories_tids['BACON'] == $value_food['tid']) {
          $bacon .= '  <li>
      <a href="food-finder?field_vendors_category_tid=' . $term->tid . '&bacon=1"><span class="nav-text-full">' . $term->name . '</span></a>
  </li>
';
        }
        if ($food_categories_tids['Deep Fried'] == $value_food['tid']) {
          $deep_fried .= '  <li>
      <a href="food-finder?field_vendors_category_tid=' . $term->tid . '&deep_fried=1"><span class="nav-text-full">' . $term->name . '</span></a>
  </li>
';
        }
        if ($food_categories_tids['On A Stick'] == $value_food['tid']) {
          $on_a_stick .= '  <li>
      <a href="food-finder?field_vendors_category_tid=' . $term->tid . '&on_a_stick=1"><span class="nav-text-full">' . $term->name . '</span></a>
  </li>
';
        }
        if ($food_categories_tids['GTOAF'] == $value_food['tid']) {
          $gtof .= '  <li>
      <a href="food-finder?field_vendors_category_tid=' . $term->tid . '&gtoaf=1"><span class="nav-text-full">' . $term->name . '</span></a>
  </li>
';
        }
      }
    }
  }


 $prefix = '<div class="title-page">
      <h1>#title</h1>
    </div>
    <div class="structs-nav-wrapper">
      <div class="nav-items-wrapper">
        <div class="nav-item">
          <ul class="nav-list">';

$suffix = '</ul>
        </div>
      </div>
    </div>';


  $all = '<div class="structs-wrapper btn_all_food">' . str_replace('#title', t('ALL FOOD'), $prefix) . $all . $suffix. '</div>';
  $bacon = '<div class="structs-wrapper btn_bacon">' . str_replace('#title', t('BACON'), $prefix) . $bacon . $suffix. '</div>';
  $on_a_stick = '<div class="structs-wrapper btn_on_a_stick">' . str_replace('#title', t('ON-A-STICK'), $prefix) . $on_a_stick . $suffix . '</div>';
  $deep_fried = '<div class="structs-wrapper btn_deep_fried">' . str_replace('#title', t('DEEP-FRIED'), $prefix) . $deep_fried . $suffix . '</div>';
  $gtof = '<div class="structs-wrapper btn_gtoaf">' . str_replace('#title', t('GREAT TASTE OF A FAIR'), $prefix) . $gtof . $suffix . '</div>';



$all_food = ' <div class="structs-btn-wrapper">
      <div class="btn-item-wrapper btn-item-full_m">
        <a href="/food-finder?all_food=1" id="btn_all_food" class="btn-item"><span class="text-btn">' . t('ALL FOOD') . '</span></a>
      </div>
      <div class="btn-item-wrapper btn-item-full_m">
        <a href="/food-finder?bacon_food=1" id="btn_bacon" class="btn-item"><span class="text-btn">' . t('BACON') . '</span></a>
      </div>
      <div class="btn-item-wrapper btn-item-full_m">
        <a href="/food-finder?on-a-stick_food=1" id="btn_on_a_stick" class="btn-item"><span class="text-btn">' . t('ON-A-STICK') . '</span></a>
      </div>
      <div class="btn-item-wrapper btn-item-full_m">
        <a href="/food-finder?deep-fried_food=1" id="btn_deep_fried" class="btn-item"><span class="text-btn">' . t('DEEP-FRIED') . '</span></a>
      </div>
      <div class="btn-item-wrapper btn-item-full_m">
        <a href="/food-finder?gtoaf=1" id="btn_gtoaf" class="btn-item"><span class="text-btn">' . t('GREAT TASTE OF A FAIR') . '</span></a>
      </div>
    </div>';



//  return $bacon . $on_a_stick . $deep_fried . $gtof;
  //return $all_food. $all . $bacon . $on_a_stick . $deep_fried;
if (isset($_GET['all_food'])) {
  return $all;
}
if (isset($_GET['bacon_food'])) {
  return $bacon;
}
if (isset($_GET['on-a-stick_food'])) {
  return $on_a_stick;
}
if (isset($_GET['deep-fried_food'])) {
  return $deep_fried;
}
if (isset($_GET['gtoaf'])) {
  return $gtof;
}
 if (!isset($_GET['all_food']) & !isset($_GET['bacon_food']) & !isset($_GET['on-a-stick_food']) & !isset($_GET['deep-fried_food']) & !isset($_GET['gtoaf'])) {
   return $all_food;
 }
  return $all_food. $all . $bacon . $on_a_stick . $deep_fried . $gtof;
}
