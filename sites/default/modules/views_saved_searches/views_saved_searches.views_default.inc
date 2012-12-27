<?php
/**
 * Implementation of hook_views_default_views().
 */
function views_saved_searches_views_default_views() {

  /* Users saved searches view */
  $view = new view;
  $view->name = 'users_saved_searches';
  $view->description = 'Users saved searches';
  $view->tag = 'Views saved searches';
  $view->view_php = '';
  $view->base_table = 'views_saved_searches';
  $view->is_cacheable = FALSE;
  $view->api_version = 2;
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
  $handler = $view->new_display('default', 'Defaults', 'default');
  $handler->override_option('fields', array(
    'search_name_1' => array(
      'label' => 'Search name',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'exclude' => 0,
      'id' => 'search_name_1',
      'table' => 'views_saved_searches',
      'field' => 'search_name',
      'relationship' => 'none',
    ),
    'timestamp' => array(
      'label' => 'Saved date',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'date_format' => 'custom',
      'custom_date_format' => 'd/m/y',
      'exclude' => 0,
      'id' => 'timestamp',
      'table' => 'views_saved_searches',
      'field' => 'timestamp',
      'relationship' => 'none',
    ),
    'view_search' => array(
      'label' => 'Run search',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'text' => 'View',
      'exclude' => 0,
      'id' => 'view_search',
      'table' => 'views_saved_searches',
      'field' => 'view_search',
      'relationship' => 'none',
    ),
    'delete_search' => array(
      'label' => 'Delete search',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'text' => 'Delete',
      'exclude' => 0,
      'id' => 'delete_search',
      'table' => 'views_saved_searches',
      'field' => 'delete_search',
      'relationship' => 'none',
    ),
    'sid' => array(
      'label' => 'Search ID',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'set_precision' => FALSE,
      'precision' => 0,
      'decimal' => '.',
      'separator' => ',',
      'prefix' => '',
      'suffix' => '',
      'exclude' => 1,
      'id' => 'sid',
      'table' => 'views_saved_searches',
      'field' => 'sid',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
    'uid' => array(
      'label' => 'User ID',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'set_precision' => FALSE,
      'precision' => 0,
      'decimal' => '.',
      'separator' => ',',
      'prefix' => '',
      'suffix' => '',
      'exclude' => 1,
      'id' => 'uid',
      'table' => 'views_saved_searches',
      'field' => 'uid',
      'override' => array(
        'button' => 'Override',
      ),
      'relationship' => 'none',
    ),
    'edit_search' => array(
      'label' => 'Edit search',
      'alter' => array(
        'alter_text' => 0,
        'text' => '',
        'make_link' => 0,
        'path' => '',
        'link_class' => '',
        'alt' => '',
        'prefix' => '',
        'suffix' => '',
        'target' => '',
        'help' => '',
        'trim' => 0,
        'max_length' => '',
        'word_boundary' => 1,
        'ellipsis' => 1,
        'html' => 0,
        'strip_tags' => 0,
      ),
      'empty' => '',
      'hide_empty' => 0,
      'empty_zero' => 0,
      'text' => 'Edit',
      'exclude' => 0,
      'id' => 'edit_search',
      'table' => 'views_saved_searches',
      'field' => 'edit_search',
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('sorts', array(
    'timestamp' => array(
      'order' => 'DESC',
      'granularity' => 'second',
      'id' => 'timestamp',
      'table' => 'views_saved_searches',
      'field' => 'timestamp',
      'relationship' => 'none',
    ),
  ));
  $handler->override_option('arguments', array(
    'uid' => array(
      'id' => 'uid',
      'table' => 'views_saved_searches',
      'field' => 'uid',
    ),
  ));
  $handler->override_option('access', array(
    'type' => 'none',
  ));
  $handler->override_option('cache', array(
    'type' => 'none',
  ));
  $handler->override_option('title', 'Saved job searches');
  $handler->override_option('empty', 'You don\'t have any saved searches at the moment. When you save a search in the future, it will appear here.');
  $handler->override_option('empty_format', '1');
  $handler->override_option('use_ajax', TRUE);
  $handler->override_option('items_per_page', 25);
  $handler->override_option('use_pager', '1');
  $handler->override_option('pager_element', 3);
  $handler->override_option('style_plugin', 'table');
  $handler = $view->new_display('page', 'Page', 'page_1');
  $handler->override_option('path', 'user/%/saved-searches');
  $handler->override_option('menu', array(
    'type' => 'tab',
    'title' => 'Saved searches',
    'description' => 'Your saved searches',
    'weight' => '2',
    'name' => 'navigation',
  ));
  $handler->override_option('tab_options', array(
    'type' => 'none',
    'title' => '',
    'description' => '',
    'weight' => 0,
    'name' => 'navigation',
  ));


  $views[$view->name] = $view;
  
  return $views;
}
