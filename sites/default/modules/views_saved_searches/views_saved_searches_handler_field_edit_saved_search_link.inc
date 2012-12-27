<?php
//$Id

/**
 * @file Custom field handlers
 */
 
/**
 * Field handler to give a link to edit the search
 */
class views_saved_searches_handler_field_edit_saved_search_link extends views_handler_field {
  function construct() {
    parent::construct();
    $this->additional_fields['search_query'] = 'search_query';
    $this->additional_fields['view_name'] = 'view_name';
    $this->additional_fields['sid'] = 'sid';
  }

  function option_definition() {
    $options = parent::option_definition();
    $options['text'] = array('default' => 'Edit', 'translatable' => TRUE);
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
    $text = !empty($this->options['text']) ? $this->options['text'] : t('edit search');
    // @TODO: Where is this $search_urls and what does it need to be?
    $search_urls = variable_get("jobs_board_saved_searches", array());
    $view_url = $search_urls[$values->{$this->aliases['view_name']}];
    return l($text, $view_url, array('query' => $values->{$this->aliases['search_query']} . "&update_saved_search=" . $values->{$this->aliases['sid']}));
  }
}