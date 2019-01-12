<?php
/*
 * Plugin Name: SMNTCS Bootstrap Modal
 * Plugin URI: https://github.com/nielslange/smntcs-bootstrap-modal
 * Description: Open any shortcode within a <a href="http://getbootstrap.com/javascript/#modals" target="_blank">Twitter Bootstrap</a> modal.
 * Author: Niels Lange
 * Author URI: https://nielslange.com
 * Text Domain: smntcs-bootstrap-modal
 * Version: 1.5
 * Requires at least: 3.0
 * Tested up to: 5.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/* Copyright 2014-2016 Niels Lange (email : info@nielslange.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Activate plugin
register_activation_hook(__FILE__, 'smntcs_bootstrap_modal_activate_plugin');
function smntcs_bootstrap_modal_activate_plugin()
{
    add_option('smntcs_bootstrap_modal_title', '');
    add_option('smntcs_bootstrap_modal_shortcode', '');
}

// Deactivate plugin
register_deactivation_hook(__FILE__, 'smntcs_bootstrap_modal_deactivate_plugin');
function smntcs_bootstrap_modal_deactivate_plugin()
{
    delete_option('smntcs_bootstrap_modal_title');
    delete_option('smntcs_bootstrap_modal_button');
    delete_option('smntcs_bootstrap_modal_shortcode');
}

// Initialize plugin
function smntcs_bootstrap_modal_admin_init()
{
    register_setting('smntcs_bootstrap_modal', 'smntcs_bootstrap_modal_title');
    register_setting('smntcs_bootstrap_modal', 'smntcs_bootstrap_modal_button');
    register_setting('smntcs_bootstrap_modal', 'smntcs_bootstrap_modal_shortcode');
}

// Add menu item in backend
function smntcs_bootstrap_modal_admin_menu()
{
    add_options_page('Bootstrap Modal', 'Bootstrap Modal', 'manage_options', 'bootstrap-modal', 'smntcs_bootstrap_modal_options_page');
}

// Add options page in backend
function smntcs_bootstrap_modal_options_page()
{
    include WP_PLUGIN_DIR . '/smntcs-bootstrap-modal/options.php';
}

// Initialize show plugin in backend
if (is_admin()) {
    add_action('admin_init', 'smntcs_bootstrap_modal_admin_init');
    add_action('admin_menu', 'smntcs_bootstrap_modal_admin_menu');
}

// Load translation(s)
add_action('plugins_loaded', 'smntcs_bootstrap_modal_load_textdomain');
function smntcs_bootstrap_modal_load_textdomain()
{
    load_plugin_textdomain('smntcs-bootstrap-modal', false, false, plugin_basename(dirname(__FILE__)) . '/languages');
}

// Add settings link on plugin page
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'smntcs_bootstrap_modal_plugin_settings_link');
function smntcs_bootstrap_modal_plugin_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=bootstrap-modal">' . __('Settings', 'smntcs-bootstrap-modal') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Define shortcode
add_shortcode('smntcs-modal', 'smntcs_bootstrap_modal_define_shortcode');
function smntcs_bootstrap_modal_define_shortcode()
{
    ?>
    <p><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><?php echo get_option('smntcs_bootstrap_modal_button'); ?></button></p>
    <?php
}

// Apply custom CSS to frontend
add_action('wp_head', 'smntcs_bootstrap_modal_css_frontend');
function smntcs_bootstrap_modal_css_frontend()
{
    ?>
<style type="text/css" media="screen">
	.modal-open { overflow: visible; }
	.modal-open, .modal-open .navbar-fixed-top, .modal-open .navbar-fixed-bottom { padding-right:0px!important; }
</style>
    <?php
}

// Apply custom CSS to frontend
add_action('admin_head', 'smntcs_bootstrap_modal_css_backend');
function smntcs_bootstrap_modal_css_backend()
{
    ?>
<style type="text/css" media="screen">
    span.shortcode { display: block; margin: 2px 0;}
    span.shortcode > input { background: inherit; color: inherit; font-size: 12px; border: none; box-shadow: none; padding: 4px 8px; margin: 0; }
</style>
    <?php
}

// Show site verification code in frontend
add_action('wp_footer', 'smntcs_bootstrap_modal');
function smntcs_bootstrap_modal()
{
    wp_register_style('bootstrap-css', plugins_url('assets/bootstrap-3.3.6/css/bootstrap.min.css', __FILE__), '', '3.3.6', 'all');
    wp_enqueue_style('bootstrap-css');
    wp_register_script('bootstrap-js', plugins_url('assets/bootstrap-3.3.6/js/bootstrap.min.js', __FILE__), array('jquery'), '3.3.6', true);
    wp_enqueue_script('bootstrap-js');
    ?>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo get_option('smntcs_bootstrap_modal_title'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo do_shortcode(get_option('smntcs_bootstrap_modal_shortcode')); ?>
                </div>
                <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', 'smntcs-bootstrap-modal');?></button>
	           </div>
            </div>
        </div>
    </div>
    <?php
}
