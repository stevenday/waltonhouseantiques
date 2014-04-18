<?php
/**
 * @file
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $submitted: Themed submission information output from
 *   theme_node_submitted().
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $build_mode: Build mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $build_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * The following variable is deprecated and will be removed in Drupal 7:
 * - $picture: This variable has been renamed $user_picture in Drupal 7.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess()
 * @see zen_preprocess_node()
 * @see zen_process()
 *
 * Custom variables:
 * - enquire_link - a link to the enquiry form for products
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix">

  <div id="product-left">
    <div id="product-top" class="clearfix">
      <div id="product-top-left">
        <?php if ($title): ?>
          <h1 class="title"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php if ($terms): ?>
          <div class="terms terms-inline"><?php print $terms; ?></div>
        <?php endif; ?>
      </div>
      <div id="product-top-right">
        <?php if ($node->field_sold[0]['value'] == '1'): ?>
            <?php 
                /*
                 * We're copying the way $field_product_price_rendered will output
                 * here so that it looks the same, bit lazy, sorry.
                 */
            ?>
            <div class="field field-type-number-decimal field-field-product-price">
                <div class="field-items">
                    <div class="field-item odd">
                        £Sold
                    </div>
                </div>
            </div> 
        <?php else: ?>
	    <?php print $field_product_price_rendered; ?>
        <?php endif; ?>
        <?php print $links ?>
      </div>
    </div>
    <div class="content">
      <?php if ($node->field_sold[0]['value'] == '1'): ?>
         <p><strong>Sorry, this product is now sold, please take a look at the similar items below for more of our current stock like this.</strong></p>
      <?php endif; ?>
      <?php print check_markup($node->content['body']['#value']); ?>
    </div>
    
    <div id="product-actions">
      <?php print $enquire_link; ?>
      <span class="phone-number">or phone: 01747 860 050</span>
    </div>
  </div><!-- /#product-left -->
  <div id="product-right">
    <?php if($product_big_image): ?>
      <!-- product images -->
      <div id="product-big-image">
        <div id="product-big-image-wrapper">
          <?php print($product_big_image); ?>
        </div>
      </div>
      <div id="product-thumbnails">
        <div id="product-thumbnails-outer-wrapper" class="clearfix">
          <div id="product-thumbnails-inner-wrapper" class="clearfix">
            <?php foreach($product_thumbnails as $key=>$thumbnail): ?>
              <?php $thumb_class = ($key == (count($product_thumbnails) - 1)) ? 'product-thumbnail last' : 'product-thumbnail'; ?>
              <div class="<?php print $thumb_class; ?>"><?php print($thumbnail); ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div><!-- /#product-right -->
</div><!-- /.node -->

