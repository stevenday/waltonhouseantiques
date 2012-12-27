<?php
// $Id:
/**
 * @file views-view-table--users-saved-searches--page-1.tpl.php
 * Display the users saved searches view
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <thead>
    <tr>
      <th class="views-field views-field-<?php print $fields['search_name_1']; ?>">
        <?php print $header['search_name_1']; ?>
      </th>
      <th class="views-field views-field-<?php print $fields['timestamp']; ?>">
        <?php print $header['timestamp']; ?>
      </th>
      <th class="views-field views-field-email-alerts">Send me alerts</th>
      <th class="views-field views-field-<?php print $fields['view_search']; ?>">
        <?php print $header['view_search']; ?>
      </th>
      <th class="views-field views-field-<?php print $fields['edit_search']; ?>">
        <?php print $header['edit_search']; ?>
      </th>
      <th class="views-field views-field-<?php print $fields['delete_search']; ?>">
        <?php print $header['delete_search']; ?>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]); ?>">
        <td class="views-field views-field-<?php print $fields['search_name_1']; ?>">
          <?php print $row['search_name_1']; ?>
        </td>
        <td class="views-field views-field-<?php print $fields['timestamp']; ?>">
          <?php print $row['timestamp']; ?>
        </td>
        <th class="views-field views-field-email-alerts">
          <?php print $row['alert_form']; ?>
        </th>
        <td class="views-field views-field-<?php print $fields['view_search']; ?>">
          <?php print $row['view_search']; ?>
        </td>
        <td class="views-field views-field-<?php print $fields['edit_search']; ?>">
          <?php print $row['edit_search']; ?>
        </td>
        <td class="views-field views-field-<?php print $fields['delete_search']; ?>">
          <?php print $row['delete_search']; ?>
        </td>    
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
