<?php
/*
 * simonfilters - 2.12.0 Build 0001
 */

// Heading
$_['heading_title']       = 'Simon Filters';

// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Success: You have modified module SimonFilter!';
$_['text_content_top']    = 'Content Top';
$_['text_content_bottom'] = 'Content Bottom';
$_['text_column_left']    = 'Column Left';
$_['text_column_right']   = 'Column Right';

$_['text_type_default']   = 'Default';
$_['text_type_checkbox']  = 'CheckBoxes';
$_['text_type_dropdown']  = 'Dropdowns';
$_['text_type_clean']  = 'Clean';
$_['text_type_horizontal']  = 'Horizontal Filters';

$_['text_type_yes']       = 'Yes';
$_['text_type_no']        = 'No';

$_['text_type_expanded']  = 'Expanded';
$_['text_type_collapsed'] = 'Collapsed';

// Entry
$_['entry_layout']        = 'Layout:';
$_['entry_position']      = 'Position:';
$_['entry_status']        = 'Status:';
$_['entry_sort_order']    = 'Sort Order:';
$_['entry_display_type']  = 'Display Type: <br /><span class="help">Choose between <i>default, checkbox, dropdown, horizontal</i> or create your own on the <b>CSS config</b> tab</span>';
$_['entry_display_totals'] = 'Display total products: <br /><span class="help">Enable this to show the product totals inside ()</span>';
$_['entry_active_filters'] = 'Active Filters:<br /><span class="help">Select the filters you want to show and their default behavior</span>';
$_['entry_client_side_attributes'] = 'Client Side Attributes:<br/><span class="help">Client-side attributes are stored in a Session Var. Use this to force filter rebuild on the clients currently browsing your site.<br>Relevant VQmod cache files will also be deleted.</span>';
$_['entry_client_side_attributes_button'] = 'Force Rebuild';
$_['entry_search_updates_button'] = 'Search for updates';
$_['entry_client_side_sorting']='Client Side Sorting:<br/><span class="help">Order in which the filters will be presented</span>';
$_['entry_client_side_items_sorting']='Client Side Items Sorting:<br/><span class="help">Order in which the filter\'s items will be presented</span>';

$_['entry_category_domid'] = 'HTML Object ID:<br /><span class="help">(for Category Layout)</span>';
$_['entry_manufacturer_domid'] = 'HTML Object ID:<br /><span class="help">(for Manufacturer Layout)</span>';
$_['entry_homepage_domid'] = 'HTML Object ID:<br /><span class="help">(for Homepage Layout)</span>';
$_['entry_search_domid'] = 'HTML Object ID:<br /><span class="help">(for Search Layout)</span>';
$_['entry_product_domid'] = 'HTML Object ID:<br /><span class="help">(for Product Layout)</span>';
$_['entry_special_domid'] = 'HTML Object ID:<br /><span class="help">(for Special Layout)</span>';
$_['entry_get_domids'] = 'Check Simon\'s Server:<br /><span class="help">Click to retrieve the IDs from Simon\'s Server central DataBase.</span>';
$_['entry_force_siblings'] = 'Force siblings on Column Left/Right:<br /><span class="help">Some custom themes place all modules inside the main content area. Check this to make SFs look for siblings.</span>';
$_['entry_get_domids_button'] = 'Get data from Simon\'s Server';
$_['entry_filter_persist'] = 'Persist data:<br /><span class="help">Check so filters are remembered while the client browses the store</span>';
$_['entry_allow_debug_data'] ='Allow sending debug data:<br/><span class="help">Allow usage data (Your email address, OpenCart version, SFs version and custom theme name) to be sent to Simon.</span>';
$_['entry_enable_front_end_diagnostics'] ='Enable frontend diagnostics:<br/><span class="help">Let the module detect if the HTML Object IDs are correctly configured and if the required stylesheet is being loaded.</span>';
$_['entry_attribute_separator']='Enable Attribute char separator:<br/><span class="help">Allows the usage of multiple Attributes per attribute item. You need to enter the desired char(s) used to split the Attribute item.</span>';
$_['entry_option_quantity_zero']='Hide Zero-Quantity Options<br/><span class="help">Hide options that have 0 (zero) on the available quantity</span>';
$_['entry_dynamic']='Allow Dynamic Filters<br/><span class="help">Filters will dynamically change to display only relevant filters.</span>';
$_['entry_force_all']='Force all filters<br/><span class="help">Turn this on if you want all existing filters to be presented.</span>';
$_['entry_filters_slider_step']='Step value<br/><span class="help">Step value for the JQuery price slider <i>or</i> number of price intervals.</span>';
$_['entry_script_ignore']='JavaScript Ignore<br/><span class="help">SemiColon (;) separeted words that SimonFilters will use to identify problematic third-party JavaScripts to ignore on after-ajax evals.</span>';
$_['entry_activefilter_simonfilters_stock_instock']='"In Stock"<br/><span class="help">Identify which of the existing stock statuses is the "In Stock" one.</span>';
$_['entry_delete_cache_for_debug']='Delete all relevant cache files on each reload<br/><span class="help">This can be useful for debugging.</span>';
$_['entry_prevent_admin_delete_cache_on_save']='Prevent deletion of cache files and reseting of client\'s filter session data on Admin Save.<br/><span class="help">This can be useful for debugging.</span>';
$_['entry_expanded_collapsed']='Default visibility<br/><span class="help">Select if filter section should be collapsed or expanded by default.</span>';
$_['entry_execute_external_js']='Extecute external js files<br/><span class="help">Check this to execute external JavaScript files on post-AJAX. Enumerate js files to ignore separated by ";"</span>';
$_['entry_active_filters_price_type']='Filter type<br/><span class="help">Select either a JQuery slider or price intervals</span>';
$_['entry_filters_hide_products_less']='Product limit<br/><span class="help">Hide price filter if number of products is less than the number entered</span>';
$_['entry_filters_hide_products_less_price']='Price limit<br/><span class="help">Hide price filter if price difference is less than the number entered (enter -1 or 0 to disable)</span>';
$_['entry_cache_buster']='Enable Cache Buster<br/><span class="help">Enable this to append a random string to filter and page links</span>';
$_['entry_force_currency']='Force front-end currency<br /><span class="help">Let customer select the currency or force one</span>';

$_['entry_active_filters_attribute'] = "Attributes";
$_['entry_active_filters_categories'] = "Categories";
$_['entry_active_filters_options'] = "Options";
$_['entry_active_filters_tags'] = "Tags";
$_['entry_active_filters_manufacturer'] = "Manufacturers";
$_['entry_active_filters_stock'] = "Stock";
$_['entry_active_filters_misc'] = "Misc";
$_['entry_active_filters_price'] = "Price";
$_['entry_active_filters_price_tax'] = 'Show Prices with taxes:<br/><span class="help">Apply taxes to the prices shown</span>';
$_['entry_active_filters_price_special'] = 'Specials:<br/><span class="help">Apply Special Prices</span>';
$_['entry_theme_config'] = "Theme Config";
$_['entry_styles'] = "CSS Config";

$_['entry_options_behavior']='Mutually Exclusive Options:<br><span class="help">If checked then only products that have all the selected options will be presented.<br/>In unchecked then products with at least one of the options selected will be presented.</span>';
$_['entry_attributes_behavior']='Mutually Exclusive Attributes:<br><span class="help">If checked then only products that have all the selected attributes will be presented.<br/>In unchecked then products with at least one of the attributes selected will be presented.</span>';
$_['entry_disableajax']='Disable AJAX:<br><span class="help">Check this to disable AJAX so when the client clicks on a filter the page will load again.</span>';
$_['entry_show_more']='Show "more...":<br><span class="help">Check this to show a more/less if number of filters is more than the number selected.</span>';
$_['entry_search_updates']='Search for updates:<br><span class="help">Connect to simon\'s server to check for updates!</span>';

$_['warning_unsupported_theme'] = "Warning: You are using a custom theme ( {0} ). SimonFilters may not work as expected. You need to configure the correct front-end HTML Object IDs.<br><br>I've set up the usual configuration. If it doesn't work you could try the \"<b>Get HTML Object IDs from Simon\'s Server</b>\" button!<br><br>If still it doesn't work then send me an email to oc@simonoop.com.";
$_['warning_main_index'] = "Warning: You haven't changed OpenCart's main index.php file as required or you've made some cut&paste mistake!<br>SimonFilters will not work as expected until you make that change.<br>Please read the documentation..<br><br>In your <b>main</b> index.php find <br><br><code>if (isset(\$request->get['route'])) {</code> <br><br>and add the following line of code just before that line:<br><br><code>\$controller->addPreAction(new Action('module/simonfilters/checkvalidity'));</code></b>";
$_['warning_admin_index'] = "Warning: You haven't changed OpenCart's admin index.php file as required or you've made some cut&paste mistake!<br>SimonFilters will not work as expected until you make that change.<br>Please read the documentation.<br><br>In your <b>admin</b> index.php find <br><br><code>if (isset(\$request->get['route'])) {</code> <br><br>and add the following line of code just before that line:<br><br><code>\$controller->addPreAction(new Action('module/simonfilters/managecache'));</code></b>";
$_['warning_invalid_tags'] = "Warning: You have tags that don't conform to OpenCart tag rules.<br/><br/> You have tags that are separated by a comma and a space or by a space and a comma when the rules clearly state that they should be separated only by a comma.<br/><br/>SimonFilters won't behave as expected until you've fixed that!";

// Error
$_['error_permission']    = 'Warning: You do not have permission to modify module SimonFilter!';
?>