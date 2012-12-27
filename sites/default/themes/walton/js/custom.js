if (Drupal.jsEnabled) {
  Drupal.behaviors.walton = function() {    
    /* Product stuff */
    if($('body').hasClass("node-type-product")) {
      // Turn links to product 'enquire' forms into colorbox iframe links instead
      if($("a.enquire-link").length > 0) {
        $("a.enquire-link").each(function() {
          $(this).attr("href", $("a.enquire-link").attr("href") + "&width=600&height=400&iframe=true");
          $(this).addClass("colorbox-load");
        });
        // We have to re-initialise colorbox so that it finds our new link
        Drupal.behaviors.initColorboxLoad();
      }
      // Make thumbnail links work
      $('#product-big-image .imagecache-product').removeAttr("width").removeAttr("height");
    }
    
    /* Search stuff */
    if($('body').hasClass("section-products") || ($('body').hasClass("section-taxonomy") && $('body').hasClass("page-views"))) {
      // Collapse the taxonomy headings so they take up less room
      // unless they have selected checkboxes inside
      $('.other-filters-wrapper .views-exposed-widget').each(function () {
        var filters = new Array('Categories', 'Periods', 'Materials');
        var label = $.trim($(this).children('label').text());
        if($.inArray(label, filters) != -1) {
          var linkLabel = '<a class="expandable" href="#categories">' + label + "</a>";
          $(this).children('label').html(linkLabel);
          if($(this).find('input:checked, .selected').length == 0) {
            $(this).children('.views-widget').hide();
          }
          $(this).children('label').children('a').click(function (e) {
            $(this).toggleClass("expanded").toggleClass("expandable");
            $(this).parent().parent().children('.views-widget').slideToggle();
            e.preventDefault();
            return false;
          });
        }
      });
      
      //Collapse the checkbox filters too unless they're checked
      $('.other-filters-wrapper .bef-tree > li').each(function () {
        if($(this).find('input:checked, .selected').length == 0) {
          $(this).children('.bef-tree-child').hide();
        }
        // Give them the right classes so that they get little arrows
        if($(this).children('.bef-tree-child').length > 0) {
          $(this).children('.form-item').children("label").addClass("expandable");
        }
        if($(this).children('.bef-tree-child .selected').length > 0) {
          $(this).children('.form-item').children(".label").addClass("expandable");
        }
        // Bind to clicks on the top level filter to close/open if it's checked
        $(this).children('.form-item').children("input[type='checkbox']").click(function () {
          if($(this).parents('li').children('ul.bef-tree-child').find('input:checked, .selected').length == 0) {
            $(this).parents('li').children('ul.bef-tree-child').slideToggle();
          }
        });
        // Bind to clicks on the sub-filters to close the parent list
        // if they're all un-checked
        $(this).children('.bef-tree-child').find("input[type='checkbox']").click(function () {
          if($(this).parents('ul.bef-tree-child').parents('li').find('input:checked').length == 0) {
            $(this).parents('ul.bef-tree-child').slideToggle();
          }
        });
      });
    }
    
    // Add calls to add this
    /**
    * @author Armin Rosu (http://about.me/arminrosu)
    * @fileoverview A short script to track addthis shares in
    *     Google Analytics - Social Interaction Tracking;
    * @version 0.1
    */

    /**
    * Ensure global _gaq Google Anlaytics queue has be initialized.
    * @type {Array}
    */
    var _gaq = _gaq || [];

    /**
    * Register Event
    * Action will be one of the addthis service codes: http://www.addthis.com/services/list
    * @param {Object} event
    */
    function addthis_listener(event) {
    _gaq.push(['_trackSocial', 'addthis', event.data.service, event.data.url]);
    }
  };
}
