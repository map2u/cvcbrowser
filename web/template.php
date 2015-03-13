<?php
function york_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id === "search_block_form") {
    $form['actions']['submit']['#value'] = '';
    $form['search_block_form']['#value'] = 'Search this site'; 
    $form['search_block_form']['#attributes']['onclick'] = "if (!this.cleared) { this.cleared = true; this.value = ''; }";
  } else if ($form_id === "search_form") {
    $form['basic']['submit']['#value'] = '';
    $form['basic']['keys']['#attributes']['placeholder'] = 'Search this site';
  }
}