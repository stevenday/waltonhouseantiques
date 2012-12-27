<?php
/**
 * @file views-exposed-form--products--page.tpl.php
 *
 * This template handles the layout of the views exposed filter form.
 * Customised for the products search view and product categories/materials
 * /periods views.
 * @SEE: views-view--products--page.tpl.php also, for the corresponding
 * view template, because the two are meshed together.
 *
 * Variables available:
 * - $widgets: An array of exposed form widgets. Each widget contains:
 * - $widget->label: The visible label to print. May be optional.
 * - $widget->operator: The operator for the widget. May be optional.
 * - $widget->widget: The widget itself.
 * - $button: The submit button for the form.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($q)): ?>
  <?php
    // This ensures that, if clean URLs are off, the 'q' is added first so that
    // it shows up first in the URL.
    print $q;
  ?>
<?php endif; ?>

<?php 
  // We display the search filter differently than the rest, so that
  // it can be full width across the page, so we get it out here
  $search_widget = $widgets['filter-keys'];
  // We remove it also, so that we can loop over the other values
  // later without duplicating the search
  unset($widgets['filter-keys']);  
?>
<div class="views-exposed-form search-filter-wrapper">
  <div class="views-exposed-widgets clear-block">
    <div class="views-exposed-widget search-widget">
      <div class="views-widget">
        <?php print $search_widget->widget; ?>
      </div>
    </div>    
    
    <div class="views-exposed-widget">
      <input type="image" src="/sites/default/themes/walton/images/search-button-large.png" id="edit-submit-products" alt="Search" />
    </div>
    
    <?php
      // Sorting options
      $sortby = (isset($_GET['sortby'])) ? $_GET['sortby'] : 'date';	
      $sortby = check_plain($sortby);
    ?>
    <div class="views-exposed-widget sort-widget">
      <label for="sortby">Sort by:&nbsp;&nbsp;</label>
      <div class="views-widget">
        Newest<input type="radio" name="sortby" value="date" <?php if($sortby=="date") { print 'checked="checked"'; } ?>/>
        Lowest price<input type="radio" name="sortby" value="price_lowest" <?php if($sortby=="price_lowest") { print 'checked="checked"'; } ?>/>
        Highest price<input type="radio" name="sortby" value="price_highest" <?php if($sortby=="price_highest") { print 'checked="checked"'; } ?>/>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="views-exposed-form other-filters-wrapper">
  <p>Refine your search:</p>
  <div class="views-exposed-widgets clear-block">  
    <?php 
      // Price range - do this custom so that we can get custom labels
      unset($widgets['filter-field_product_price_value']);  
      $min = (isset($_GET['price_range']['min'])) ? $_GET['price_range']['min'] : '';
      $min = check_plain($min);
      $max = (isset($_GET['price_range']['max'])) ? $_GET['price_range']['max'] : '';
      $max = check_plain($max);
    ?>
    <div class="views-exposed-widget">
      <label>Price range</label>
      <div class="price-range-widget-wrapper clearfix">
        <div class="form-item" id="edit-price-range-min-wrapper"> 
          <label for="edit-price-range-min">&pound;</label>
          <input type="text" maxlength="128" name="price_range[min]" id="edit-price-range-min" size="30" value="<?php print $min; ?>" class="form-text" />
        </div> 
        <div class="form-item" id="edit-price-range-max-wrapper"> 
          <label for="edit-price-range-min">to:&nbsp;&nbsp;&pound;</label>
          <input type="text" maxlength="128" name="price_range[max]" id="edit-price-range-max" size="30" value="<?php print $max; ?>" class="form-text" /> 
        </div>  
      </div>
    </div>
    
    <?php foreach($widgets as $id => $widget): ?>
      <div class="views-exposed-widget">
        <?php if (!empty($widget->label)): ?>
          <label for="<?php print $widget->id; ?>">
            <?php print $widget->label; ?>
          </label>
        <?php endif; ?>
        <?php if (!empty($widget->operator)): ?>
          <div class="views-operator">
            <?php print $widget->operator; ?>
          </div>
        <?php endif; ?>
        <div class="views-widget">
          <?php print $widget->widget; ?>
        </div>
      </div>
    <?php endforeach; ?>
    
    <?php // Extra refine/reset buttons ?>
    <div class="views-exposed-widget">
      <input type="submit" id="product-search-refine" class="form-submit" value="Refine" />
      &nbsp;&nbsp;&nbsp;
      <input type="reset" id="product-search-reset" class="form-submit" value="Reset" />
    </div>
  </div>
</div>