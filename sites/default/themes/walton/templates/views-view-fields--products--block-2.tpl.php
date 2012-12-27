<?php
// Copied from: $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields--products--page.tpl.php
 * Overriden view template for products pages (searches)
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>

<div class="views-field-<?php print $fields['field_product_images_fid']->class; ?>">
  <div class="field-content">
    <?php print $fields['field_product_images_fid']->content; ?>
    <div class="views-field-<?php print $fields['field_product_price_value']->class; ?>">
      <span class="field-content">
        <?php print $fields['field_product_price_value']->content; ?>
      </span>
    </div>
  </div>
</div>
<div class="product-bottom clearfix">
  <div class="views-field-<?php print $fields['title']->class; ?>">
    <span class="field-content">
      <?php print $fields['title']->content; ?>
    </span>
  </div>
</div>
