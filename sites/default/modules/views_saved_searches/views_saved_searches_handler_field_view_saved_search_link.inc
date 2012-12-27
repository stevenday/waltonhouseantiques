<?php

//$Id



/**

 * @file Custom field handlers

 */

 

/**

 * Field handler to give a link to re-run the search

 */

class views_saved_searches_handler_field_view_saved_search_link extends views_handler_field {

  function construct() {

    parent::construct();

    $this->additional_fields['search_query'] = 'search_query';

    $this->additional_fields['view_name'] = 'view_name';

  }



  function option_definition() {

    $options = parent::option_definition();

    $options['text'] = array('default' => 'View', 'translatable' => TRUE);

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

    $text = !empty($this->options['text']) ? $this->options['text'] : t('run search');


    $view_url = $values->{$this->aliases['view_name']};

    return l($text, $view_url, array('query' => $values->{$this->aliases['search_query']}));

  }

}
