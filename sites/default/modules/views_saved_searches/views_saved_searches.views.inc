<?php
//$Id

/**
 * Implementation of hook_views_data
 * Expose this module's data to views
 */
function views_saved_searches_views_data() {
  $data = array(
    //Saved searches table
    'views_saved_searches' => array(
      //explain the table overall to views
      'table' => array(
        'group' => 'Views Saved Searches',
        'base' => array(
          'field' => 'sid',
          'title' => t('Saved Search'),
          'help' => t('Saved searches'),
          'weight' => -10,
        ),
      ),
      //sid field
      'sid' => array(
        'title' => 'Search ID',
        'help' => 'The search id of the saved search.',
        'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_numeric',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
      ),
      //uid field
      'uid' => array(
        'title' => 'User ID',
        'help' => 'The user id of the user who saved the search.',
        'field' => array(
          'handler' => 'views_handler_field_numeric',
          'click sortable' => TRUE,
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_user_uid',
          'numeric' => TRUE,
          'validate type' => 'uid',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_numeric',
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
        'relationship' => array(
          'handler' => 'views_handler_relationship',
          'base' => 'users',
          'base_field' => 'uid',
        ),
      ),
      //view_name field
      'view_name' => array(
        'title' => 'View Name',
        'help' => 'The name of the view that returns the search results.',
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_string',
        ),
        'filter' => array(
          'handler' => 'views_saved_searches_handler_filter_view_name',
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
      ),
      //search_name field
      'search_name' => array(
        'title' => 'Search Name',
        'help' => 'The name the user gave the search.',
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE,
        ),
        'argument' => array(
          'handler' => 'views_handler_argument_string',
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_string',
        ),
        'sort' => array(
          'handler' => 'views_handler_sort',
        ),
      ),
      //search_query field
      'search_query' => array(
        'title' => 'Search Query',
        'help' => 'The query for the search.',
        'field' => array(
          'handler' => 'views_handler_field',
        ),
      ),
      //timestamp field
      'timestamp' => array(
        'title' => 'Search Timestamp',
        'help' => 'The created timestamp for the search.',
        'field' => array(
          'handler' => 'views_handler_field_date',
          'click sortable' => TRUE,
        ),
        'filter' => array(
          'handler' => 'views_handler_filter_date',
        ),
        'sort' => array(
          'handler' => 'views_handler_sort_date',
        ),
      ),
      //link to run search
      'view_search' => array(
        'field' => array(
          'title' => 'Search Link',
          'help' => 'Provide a url to run the search.',
          'handler' => 'views_saved_searches_handler_field_view_saved_search_link',
        ),
      ),
      //link to edit saved searche
      'edit_search' => array(
        'field' => array(
          'title' => 'Edit Search Link',
          'help' => 'Provide a url to edit the saved search.',
          'handler' => 'views_saved_searches_handler_field_edit_saved_search_link',
        ),
      ),
      //link to delete search from saved searches
      'delete_search' => array(
        'field' => array(
          'title' => 'Delete Search Link',
          'help' => 'Provide a url to delete the saved search.',
          'handler' => 'views_saved_searches_handler_field_delete_saved_search_link',
        ),
      ),
    ),
  );
  
  return $data;
}

/**
 * Implementation of hook_views_handlers()
 */
function views_saved_searches_views_handlers() {
  return array(
    'handlers' => array(
      'views_saved_searches_handler_field_view_saved_search_link' => array(
        'parent' => 'views_handler_field_url',
      ),
      'views_saved_searches_handler_field_edit_saved_search_link' => array(
        'parent' => 'views_handler_field_url',
      ),
      'views_saved_searches_handler_field_delete_saved_search_link' => array(
        'parent' => 'views_handler_field_url',
      ),
      'views_saved_searches_handler_filter_view_name' => array(
        'parent' => 'views_handler_filter_in_operator',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_pre_render()
 */
function views_saved_searches_views_pre_render(&$view) {
  // only show an 'save this search' links on search views
  // if there are user supplied arguments and if there are no errors
  global $user;
  if(in_array($view->name . "_" . $view->current_display, variable_get("views_saved_searches_view_names", array()))) {
    // They can save a search, can they save this search?
    // form_get_errors() returns null if there are no errors
    $errors = form_get_errors();
    if(count($view->exposed_input) > 0 && !isset($errors)) 
    {      //either put a save this search link, or put an 'update this search link'
      if(isset($_GET['update_saved_search'])){
        drupal_set_message(t("To edit your saved search, change the parameters as you wish, then submit the search to check you're happy with the results. Then you can click the 'Update saved search' link at the bottom of the form to save your changes."));
      }
      elseif(isset($_GET['new_search_submitted'])){
        $view->attachment_before .= theme("update_this_search_link", $view, $_GET['new_search_submitted']);
      }
      else {
        //not from an existing saved search
        $view->attachment_before .= theme("save_this_search_link", $view);
      }
    }
  }
}
