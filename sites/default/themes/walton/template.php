<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to walton_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: walton_breadcrumb()
 *
 *   where walton is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function walton_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function walton_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function walton_preprocess_page(&$vars, $hook) {
  // try to add an iframe class for pages loaded in an iframe
  // This works for pages where it's in the url already, and 
  // also webform submissions where data field 5 is set to "true"
  if (isset($_GET['iframe']) && $_GET['iframe'] == "true") {
    $vars['classes_array'][] = " iframe";
  }
  elseif(arg(0) == 'node' && is_numeric(arg(1))) {
    module_load_include('inc', 'webform', 'includes/webform.submissions');
    $nid = arg(1);
    $sid = $_GET['sid'];
    $submission = webform_get_submission($nid, $sid);
    if($submission && $submission->data[5]['value'][0] == "true") {
      $vars['classes_array'][] = " iframe";
    }
  }
  
  // Allow custom page templates for each content type
  if (isset($vars['node'])) {
    // This code looks for any page-custom_content_type.tpl.php page
    $vars['template_files'][] = 'page-'. str_replace('_', '-', $vars['node']->type);  
  }
}
// */

/**
 * Preprocess function for regions 
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function walton_preprocess_region(&$vars, $hook){
  if(in_array($vars['region'], array("feature_block_2", "footer"))) {
    $vars['classes'] .= " clearfix";
  }
}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function walton_preprocess_node(&$vars, $hook) {
  // Run node-type-specific preprocess functions, like
  // walton_preprocess_node_page() or walton_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $vars['node']->type;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}

/**
 * Preprocess function specifically for products
 */
function walton_preprocess_node_product(&$vars, $hook) {
  //@TODO - look up webform node id some how (variable?)
  $vars['enquire_link'] = l(t("Enquire now"), 'node/11', array("query" => array("product" => $vars['nid']), 'attributes' => array('class' => 'enquire-link')));
  
  // Thumbnails
  $vars['product_thumbnails'] = array();
  foreach($vars['node']->field_product_images as $image_id => $image) {
    if(isset($image['fid'])) {
      $thumb = theme('imagecache', 'product_page_thumbnail', $image['filepath'], $image['data']['title'], $image['data']['alt']);
      $vars['product_thumbnails'][] = l($thumb, 
                                        imagecache_create_path('product_zoom', $image['filepath']), 
                                        array('html' => TRUE,
                                              'attributes' => array('class' => 'product-thumb-link cloud-zoom-gallery',
                                                                    'rel' => "useZoom: 'zoom1', smallImage: '" . url(imagecache_create_path('product', $image['filepath'])) . "'"
                                                                    ),
                                              'query' => array('image' => $image_id)
                                            )
                                      );
    }
  }
  // Big image
  $image_id = (isset($_GET['image'])) ? check_plain($_GET['image']) : 0;  
  if(isset($vars['node']->field_product_images[$image_id])) {
    $image = $vars['node']->field_product_images[$image_id];
    // Use cloudzoom, but do it manually so we can add our own options for the JS
    $small = theme('imagecache', 'product', $image['filepath'], $image['data']['title'], $image['data']['alt']);
    $vars['product_big_image'] = l($small,
                                  imagecache_create_path('product_zoom', $image['filepath']),
                                  array('html' => TRUE,
                                        'attributes' => array('class' => 'cloud-zoom', 
                                                              'id' => 'zoom1', 
                                                              'rel' => "position:'product-left', width:526")
                                      )
                                  );
  }
}

/**
 * Preprocess function specifically for webform 11 (product enquiries)
 */
function walton_preprocess_webform_form_11(&$vars, $hook) {
  if(isset($_GET['product'])) {
    $product = node_load($_GET['product']);
    $vars['product'] = $product;
    $vars['product_thumb'] = theme('imagecache', 'product_thumbnail', $product->field_product_images[0]['filepath'], $product->field_product_images[0]['data']['title'], $product->field_product_images[0]['data']['alt']);
  }
}

/**
 * Theme function for forms, so that we can remove the wrapper
 * div on product search forms
 */
function walton_form($element) {
  //krumo($element);
  if(in_array($element['#id'], array('views-exposed-form-products-page-1', 'views-exposed-form-products-page-2', 'views-exposed-form-products-page-3', 'views-exposed-form-products-page-4'))) {
    // NOTE: We don't close the form tag, so that we can
    // put our view results inside it and hence get the alignment
    // we want in our page:
    // @SEE: views-view--products--page.tpl.php for the </form> tag
    $action = $element['#action'] ? 'action="' . check_url($element['#action']) . '" ' : '';
    return '<form ' . $action . ' accept-charset="UTF-8" method="' . $element['#method'] . '" id="' . $element['#id'] . '"' . drupal_attributes($element['#attributes']) . ">\n" . $element['#children'] . "\n";
  }
  else {
    return theme_form($element);
  }  
}

/**
 * preprocess function for unformatted view, so that we can 
 * give different classes to different views rows in product
 * views 
 */
function walton_preprocess_views_view_unformatted(&$vars) {
  for($i = 0; $i < count($vars['classes']); $i++) {
    switch ($i % 3) {
      case 0:
        $class = "column-1";
      break;
      case 1:
        $class = "column-2";
      break;
      case 2:
        $class = "column-3";
      break;
    }
    $vars['classes'][$i] .= " " . $class;
  }
}

/** 
 * Function to preprocess product views 
 */
function walton_preprocess_views_view__products__page(&$vars) {
  // Test if we have more than one page of results, but haven't used any
  // filters and if so, explain to use them
  if(count($vars['view']->exposed_input) == 0 ||
     ($vars['view']->exposed_input['price_range']['max'] == "" &&
      $vars['view']->exposed_input['price_range']['min'] == "" &&
      $vars['view']->exposed_input['keys'] == "" &&
      (!isset($vars['view']->exposed_input['category']) || count($vars['view']->exposed_input['category']) == 0) &&
      (!$vars['view']->exposed_input['material'] || count($vars['view']->exposed_input['material']) == 0)  &&
      (!$vars['view']->exposed_input['period'] || count($vars['view']->exposed_input['period']) == 0))) {
        if(count($vars['view']->result) > $vars['view']->pager['items_per_page']) {
          $vars['view_message'] = '<p id="product-search-tip">Tip: use the filters on the right to refine your search and find exactly what you\'re looking for</p>';
        }
  }
  elseif($vars['view']->attachment_before != "") {
    //If not, offer to save the search
    $vars['view_message'] = $vars['view']->attachment_before;
  }
}

/**
 * Overriden theme function to theme 'save this search' links
 */
function walton_save_this_search_link($view) {
  //make a link for the save this search link
  //we need to save the views get args, but not
  //those to do with paging
  $view_args = array();
  
  $url_parts = explode("?", request_uri());
  //request_uri gives a leading slash which we don't want
  $query = $url_parts[1];
  //we don't want all the query though
  $query_parts = explode("&", $query);
  foreach($query_parts as $index => $variable) {
    $variable_name = explode("=", $variable);
    if($variable_name != "page") {
      $view_args[] = $variable;
    }
  }
  $view_query = implode("&", $view_args);
  
  //Check if we're logged in or not
  if(user_is_anonymous()) {
    $link = "user/register";
    // save things in the session too, so that they can still save
    // their search afterwards
    $_SESSION['views_saved_searches'] = array(
      "view" => $view->name,
      "query" => $view_query,
    );
  }
  else {
    $link = 'views-saved-searches/save-search/add/' . $view->name . "/" . $view_query;
  }
  return "<div class='save-this-search-link'><p>Why not " . l(t('Save this search'), $link, array('attributes' => array('class' => 'form-submit'))) . " and next time we'll do the searching for you!</p><p>When you save searches you can get regular email alerts if any new stock matches your search, so if you're looking for that perfect piece, why not give a try?</div>";
}

/**
 * Preprocess function for the 'latest products' blcok that
 * goes in a column
 */
function walton_preprocess_views_view_list(&$vars) {
  if($vars['view']->name == "products") {
    foreach($vars['classes'] as $id => $row) {
      $vars['classes'][$id] = $row . " clearfix";
    }
  }  
}

/**
 * Override theme function for form elements, so that we
 * can add clearfix classes to them for the checkboxes on
 * product search/browse views
 */
function walton_form_element($element, $value) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  $output = '<div class="form-item clearfix"';
  if (!empty($element['#id'])) {
    $output .= ' id="' . $element['#id'] . '-wrapper"';
  }
  $output .= ">\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="' . $t('This field is required.') . '">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="' . $element['#id'] . '">' . $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) . "</label>\n";
    }
    else {
      $output .= ' <label>' . $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) . "</label>\n";
    }
  }

  $output .= " $value\n";

  if (!empty($element['#description'])) {
    $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/**
 * Themes a select drop-down as a collection of links in a tree
 * copied from Better exposed filters module's theme_select_as_links and
 * theme_select_as_tree.
 *
 * This is enabled by the mere_general's form_alter hook when 
 * we're on the Browse products page - so that you can't try to
 * 'browse' two categories at the same time.
 *
 * @see theme_select(), http://api.drupal.org/api/function/theme_select/6
 * @param object $element - An associative array containing the properties of the element.
 *                          Properties used: title, value, options, description, name
 * @return HTML string representing the form element.
 */
function walton_select_as_links($element) {
  $output = '<ul class="bef-tree">';
  $name = $element['#name'];
  $selected_options = (array)$element['#post'][$name];   // the selected keys from #options
  if (empty($_REQUEST[$name])) {
    $selected_options[] = $element["#$name"];
  }
  $curr_depth = 0;
  foreach ($element['#options'] as $option => $elem) {
    // Check for Taxonomy-based filters
    if (is_object($elem)) {
      list($option, $elem) = each(array_slice($elem->option, 0, 1, TRUE));
    }

    // Build hierarchy based on prefixed '-' on the element label
    preg_match('/^(-*).*$/', $elem, $matches);
    $depth = strlen($matches[1]);
      
    // Build link, or plain element (for currently selected item)
    // Custom ID for each link based on the <select>'s original ID
    $html = '';
    
    $id = form_clean_id($element['#id'] . '-' . $option);
    $trimmed_label = ltrim($elem, "-");
    if (array_search($option, $selected_options) === FALSE) {
      // get path to current view without current argument
      $current_url_parts = explode("/", request_uri());
      $view_path = arg(0) . "/" . arg(1);
      $link = l($trimmed_label, $view_path . "/" . $option, array('attributes' => array('class' => 'label')));
      $html .= theme('form_element', array('#id' => $id), $link);
    } else {
      // Selected value is output without a link
      // TODO: Does that look funny in the display?  Should add a "current" class to this elem?
      $html .= theme('form_element', array('#id' => $id), '<span class="label selected">' . $trimmed_label . "</span>");
    }
    
    // Deal with tree 
    if ($depth > $curr_depth) {
      // We've moved down a level: create a new nested <ul>
      // TODO: Is there is a way to jump more than one level deeper at a time?  I don't think so...
      $output .= "<ul class='bef-tree-child bef-tree-depth-$depth'><li>$html";
      $curr_depth = $depth;
    }
    elseif ($depth < $curr_depth) {
      // We've moved up a level: finish previous <ul> and <li> tags, once for each level, since we
      // can jump multiple levels up at a time.
      while ($depth < $curr_depth) {
        $output .= '</li></ul>';
        $curr_depth--;
      }
      $output .= "</li><li>$html";
    }
    else {
      // Remain at same level as previous entry. No </li> needed if we're at the top level
      if (0 == $curr_depth) {
        $output .= "<li>$html";
      }
      else {
        $output .= "</li><li>$html";
      }
    }
  }

  $properties = array(
    '#title' => $element['#title'],
    '#description' => $element['#description'],
  );
  return '<div class="walton-select-as-links-tree">'
    . theme('form_element', $properties, $output)
    . '</div>';
}


/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function walton_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function walton_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */
