<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function york_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $form['support']['skip_link2_anchor'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Anchor ID for the second "skip link"'),
    '#field_prefix'        => '#',
    '#default_value' => theme_get_setting('skip_link2_anchor'),
    '#description'   => t("Specify the HTML ID of the element that the accessible-but-hidden “skip link” should link to. Note: that element should have the tabindex=\"-1\" attribute to prevent an accessibility bug in webkit browsers."),
  );

  $form['support']['skip_link2_text'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Text for the second "skip link"'),
    '#default_value' => theme_get_setting('skip_link2_text'),
    '#description'   => t("For example: Jump to navigation, Skip to content"),
  );

  $form['logo']['logo_link'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Logo URL'),
    '#default_value' => theme_get_setting('logo_link'),
    '#description'   => t("Where the logo links to when clicked. (Perhaps an external site)."),
  );

  $form['logo']['logo_alt_text'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Logo Alt Text'),
    '#default_value' => theme_get_setting('logo_alt_text'),
  );

  unset($form['breadcrumb']);
}