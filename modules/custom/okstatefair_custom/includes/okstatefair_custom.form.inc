<?php

/**
 * @file
 * clri_custom.form.inc
 */

/**
 * Custom page with site settings
 */
function okstatefair_custom_site_setings_form() {
  $form = array();
  $form['main_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('Main info'),
    '#weight' => 1,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['main_info']['facebook'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook'),
    '#default_value' => variable_get('facebook', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['instagram'] = array(
    '#type' => 'textfield',
    '#title' => t('Instagram'),
    '#default_value' => variable_get('instagram', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['twitter'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter'),
    '#default_value' => variable_get('twitter', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['pinterest'] = array(
    '#type' => 'textfield',
    '#title' => t('Pinterest'),
    '#default_value' => variable_get('pinterest', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['youtube'] = array(
    '#type' => 'textfield',
    '#title' => t('Youtube'),
    '#default_value' => variable_get('youtube', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['tickets'] = array(
    '#type' => 'textfield',
    '#title' => t('Tickets'),
    '#default_value' => variable_get('tickets', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['main_info']['foodfinder'] = array(
    '#type' => 'textfield',
    '#title' => t('FoodFinder'),
    '#default_value' => variable_get('foodfinder', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['event_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('Event info'),
    '#weight' => 1,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['event_info']['event_park_warning'] = array(
    '#type' => 'textarea',
    '#title' => t('Park Event Warnig'),
    '#default_value' => variable_get('event_park_warning', ''),
    '#size' => 60,
  );

  $form['footer_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer info'),
    '#weight' => 10,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['footer_info']['footer_large'] = array(
    '#type' => 'textfield',
    '#title' => t('Footer main logo'),
    '#default_value' => variable_get('footer_large', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );
  $form['footer_info']['mobileapplication_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Mobile application url'),
    '#default_value' => variable_get('mobileapplication_url', ''),
    '#size' => 80,
    '#maxlength' => 128,
  );

  return system_settings_form($form);
}