<?php
//$Id

/**
 * @file Custom field handler for a saved search delete link
 */
 
/**
 * Field handler to give a link to delete a saved search
 */
class views_saved_searches_handler_field_delete_saved_search_link extends views_handler_field {
  function construct() {
    parent::construct();
    $this->additional_fields['sid'] = 'sid';
  }

  function option_definition() {
    $options = parent::option_definition();
    $options['text'] = array('default' => 'Delete', 'translatable' => TRUE);
    return $options;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text to display'),
      '#default_value' => $this->options['text'],
    );
  }

  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function render($values) {
    $text = !empty($this->options['text']) ? $this->options['text'] : t('Delete');
    return l($text, "views-saved-searches/save-search/delete/" . $values->{$this->aliases['sid']});
  }
}