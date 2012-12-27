<?php
// $Id:

/**
 * Filter based on view_name
 * Allowing multiple view names
 */
class views_saved_searches_handler_filter_view_name extends views_handler_filter_in_operator {
  function get_value_options() {
    $options = array();
    foreach(variable_get("views_saved_searches", array()) as $name => $url) {
      $options[$name] = $name;
    }
    $this->value_options = $options;
  }
}